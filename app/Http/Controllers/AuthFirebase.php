<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Kreait\Firebase\Factory;
function authenticateUser($eail, $password) {
    // Autenticación con Firebase
    $serviceAccount = 'app\config\credential.json';

    $firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

    $auth = $firebase->createAuth();
    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $firebaseUser = $signInResult->firebaseUserId();

        // Si la autenticación es exitosa, generamos un token JWT
        $jwtSecretKey = env('SECRET_PHAR');  // Define una clave secreta segura
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // Token válido por 1 hora

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'sub' => $firebaseUser,
            'email' => $email,
        ];

        $jwtToken = JWT::encode($payload, $jwtSecretKey, 'HS256');
        return $jwtToken;

    } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
        echo 'Invalid password!';
        return null;
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        echo 'User not found!';
        return null;
    }
}

$email = 'user@example.com';
$password = 'user_password';
$token = authenticateUser($email, $password);

if ($token) {
    echo "JWT Token: " . $token;
}
?>
