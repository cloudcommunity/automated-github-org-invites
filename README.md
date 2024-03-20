# Automated GitHub Org Invites

This PHP script enables users to receive an invitation to a specified GitHub organization by submitting their GitHub username. It handles POST requests from a simple form, sanitizes the input username, and uses the GitHub API to send an invitation to the provided GitHub username to join the organization. The script utilizes cURL for API communication and requires a valid personal access token with sufficient permissions. It includes basic error handling to provide feedback on the success or failure of the invitation process.

This script in action: https://cloudstudy.net/invite2github

References:
- https://github.com/thundergolfer/automated-github-organization-invites
- https://github.com/obumnwabude/github-invite
- https://dev.to/github/automating-org-invitations-with-github-37b9
- https://medium.com/code-applied-to-life/automated-github-organization-invites-3e940aa27040
- https://stackoverflow.com/questions/42948567/automatic-invites-to-your-github-organisation
