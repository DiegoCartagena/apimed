<?php
namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_ConferenceDataCreateRequest;
use Google_Service_Calendar_ConferenceSolutionKey;
use Google_Service_Calendar_CreateConferenceRequest;
use Google_Service_Calendar_EventAttendee;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\CitasMedicas;

class GoogleController extends Controller
{

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    
    }
    public function redirectToGoogle()
    {
        //var_dump(env('GOOGLE_CLIENT_ID'));
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        
        $authUrl = $client->createAuthUrl();
        return ['res'=>true,'url'=>$authUrl];
    }
    
    public function handleGoogleCallback()
    {
    $client = new Google_Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
   
   $client->addScope(Google_Service_Calendar::CALENDAR);
    $client->authenticate(request('code'));
    $token = $client->getAccessToken();
    //session(['google_token' => $token]);
    return $this->createEvent(null,$token);
}

public function createEvent(Request $request = null, $token)
{
    //var_dump($token["access_token"]);die;
    $client = new Google_Client();
    $client->setAccessToken($token["access_token"]);

    $calendarService = new Google_Service_Calendar($client);

    $event = new Google_Service_Calendar_Event([
        'summary' => 'Medicina General',
        'start' => new Google_Service_Calendar_EventDateTime([
            'dateTime' => '2024-10-02T22:50:00',
            'timeZone' => 'America/Santiago',
        ]),
        'end' => new Google_Service_Calendar_EventDateTime([
            'dateTime' => '2024-10-02T23:50:00',
            'timeZone' => 'America/Santiago',
        ]),
        'attendees' => [
            new Google_Service_Calendar_EventAttendee(['email' => 'diegocartagena4b2015@gmail.com']),
            new Google_Service_Calendar_EventAttendee(['email' => 'd.develop2022@gmail.com'])
        ],
    ]);

    $conferenceSolutionKey = new Google_Service_Calendar_ConferenceSolutionKey();
    $conferenceSolutionKey->setType('hangoutsMeet');

    $createRequest = new Google_Service_Calendar_CreateConferenceRequest();
    $createRequest->setRequestId('uniqueRequestId12345');
    $createRequest->setConferenceSolutionKey($conferenceSolutionKey);

    $conferenceData = new Google_Service_Calendar_ConferenceData();
    $conferenceData->setCreateRequest($createRequest);

    $event->setConferenceData($conferenceData);

    $createdEvent = $calendarService->events->insert('primary', $event, ['conferenceDataVersion' => 1]);

    return redirect('http://localhost:4200/agenda');//->with('message','Cita creada con exito');//response()->json(['res'=>true,"mensaje"=>"Cita Creada con exito"]);
}
public function redirectToGoogleLogin()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI_LOGIN')); // Redirigir para login
        $client->addScope('email');
        $client->addScope('profile');
        
        $authUrl = $client->createAuthUrl();
        
        return ['res'=>true,'url'=>$authUrl];
    }

    /**
     * Manejar la respuesta de Google y autenticar al usuario.
     */
    public function handleGoogleLoginCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI_LOGIN')); // Redirigir para login

        // Obtener el código de autenticación de Google
        $client->authenticate($request->input('code'));
        $token = $client->getAccessToken();

        // Establecer el token de acceso
        $client->setAccessToken($token['access_token']);

        // Obtener la información del perfil de usuario
        $oauth2 = new \Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Extraer la información del usuario de Google
        $googleId = $userInfo->id;
        $name = $userInfo->name;
        $email = $userInfo->email;
        $picture = $userInfo->picture;
        $date = date('Y-m-d');
        //var_dump($name);die;
            try {
                $user = UserModel::firstOrCreate(
                     ['email' => $email], // Búsqueda por correo electrónico
                     [
                         'nombre' => $name,
                         'aPaterno' => explode(' ',$name)[1],
                         //'aMaterno' => ($name[2]) ? $name[2] : '',
                         'created_at' => $date,
                         'password' => hash_hmac('sha256', $name.'.2024$',strval(env('SECRET_PHAR'))),
                         'id_perfil' => 3
                     ]
                 );
                $dataLogin = new Request;
                $dataLogin->email = $email;
                $dataLogin->password = $name.'.2024$';
                 // Buscar al usuario en tu base de datos o crear uno nuevo
                 // Iniciar sesión al usuario
                 $this->userController->login($dataLogin);
         
                 // Redirigir al usuario a la aplicación frontend o a donde desees
                 return redirect('http://localhost:4200/index');//->with(array('message'=> 'usuario logeado con exito'));
             
            } catch (\Exception $e) {
                
            }
        }
}