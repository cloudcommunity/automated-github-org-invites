# Automated GitHub Org Invites

This PHP script enables users to receive an invitation to a specified GitHub organization by submitting their GitHub username. It handles POST requests from a simple form, sanitizes the input username, and uses the GitHub API to send an invitation to the provided GitHub username to join the organization. The script utilizes cURL for API communication and requires a valid personal access token with sufficient permissions. It includes basic error handling to provide feedback on the success or failure of the invitation process.
