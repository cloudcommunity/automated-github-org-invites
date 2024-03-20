<?php

/*
 * This PHP script enables users to receive an invitation to a specified GitHub organization by submitting their GitHub username. 
 * It handles POST requests from a simple form, sanitizes the input username, and uses the GitHub API to send an invitation to 
 * the provided GitHub username to join the organization. The script utilizes cURL for API communication and requires a valid 
 * personal access token with sufficient permissions. It includes basic error handling to provide feedback on the success or failure of the invitation process.
 */

/*
 * Copyright (c) 2024 Cloud Study Network
 * Website: https://cloudstudy.net/
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

// Configuration
$accessToken = 'YOUR_PERSONAL_ACCESS_TOKEN';
$orgName = 'YOUR_ORGANIZATION_NAME';
$username = ''; // This will be set based on user input

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

    // GitHub API URL for sending invitations
    $url = 'https://api.github.com/orgs/' . $orgName . '/invitations';

    // Fetch the user ID based on the username
    $userUrl = 'https://api.github.com/users/' . $username;
    $ch = curl_init($userUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $accessToken,
        'User-Agent: GitHubOrgInvite',
        'Accept: application/vnd.github.v3+json',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $userResponse = curl_exec($ch);
    curl_close($ch);

    $userData = json_decode($userResponse, true);
    $userId = $userData['id'] ?? null;

    if ($userId) {
        $data = ['invitee_id' => $userId];

        // Use cURL to send the invitation
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $accessToken,
            'User-Agent: GitHubOrgInvite',
            'Content-Type: application/json',
            'Accept: application/vnd.github.v3+json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the invitation was successful
        if ($httpCode == 201) {
            echo "Invitation sent successfully to " . htmlspecialchars($username) . ".";
        } else {
            echo "Failed to send invitation. HTTP status code: " . $httpCode . ".";
        }
    } else {
        echo "Could not find user " . htmlspecialchars($username) . ".";
    }
} else {
    // Show the form
?>

<form action="invite.php" method="post">
    <label for="username">Enter your GitHub username to receive an invite:</label><br>
    <input type="text" id="username" name="username" required><br>
    <input type="submit" value="Receive Invite">
</form>

<?php
}
?>
