<?php
require_once '../Controller/postC.php';
require_once '../Controller/entretientC.php';

$postC = new postC();
$entretientC = new entretientC();

$posts = $postC->afficherPosts();

if (!$posts) {
    echo "No posts found.";
    exit();
}

foreach ($posts as $post) {
    $typePreventif = $post['TypePreventif'];
    $dateFabrication = new DateTime($post['dateFabrication']);
    $now = new DateTime();
    $interval = $dateFabrication->diff($now);

    $shouldNotify = false;
    $intervalDays = $interval->days;

    switch ($typePreventif) {
        case 'Daily':
            $shouldNotify = true;
            break;
        case 'Weekly':
            $shouldNotify = $intervalDays % 7 === 0;
            break;
        case 'Monthly':
            $shouldNotify = $intervalDays % 30 === 0;
            break;
        case 'Yearly':
            $shouldNotify = $intervalDays % 365 === 0;
            break;
    }

    if ($shouldNotify) {
        $email = 'nihedabdworks@gmail.com'; 
        $message = 'Entretient is due for post: ' . $post['nom'];

        // Send email
        $apiKey = 'Your API key'; 
        $senderEmail = 'your mail'; 
        $senderName = 'SagemCom';

        $data = [
            'sender' => ['name' => $senderName, 'email' => $senderEmail],
            'to' => [['email' => $email]],
            'subject' => 'Entretient Notification',
            'htmlContent' => '<p>' . $message . '</p>'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'api-key: ' . $apiKey,
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch) . "\n";
        } else if ($http_status != 201) {
            echo 'HTTP status: ' . $http_status . ' Response: ' . $result . "\n";
        } else {
            echo "Email sent successfully.\n";
            // Log the entretient
            $entretient = new entretient($message, date('Y-m-d H:i:s'), $post['id']);
            if ($entretientC->ajouterEntretient($entretient)) {
                echo "Entretient logged successfully.\n";
            } else {
                echo "Failed to log entretient.\n";
            }
        }

        curl_close($ch);
    } else {
        echo "No notification needed for post: " . $post['nom'] . "\n";
    }
}
?>
