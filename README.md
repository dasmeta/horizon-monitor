## Horizon application monitoring separate laravel application queue workers

copy environments from .env.example to .env

For horizon auth you need to connect it with authentic and setup right environments
```
OAUTH_PROVIDER=authentik
OAUTH_CLIENT_ID=authentik-client-id
OAUTH_CLIENT_SECRET=authentik-client-secret
OAUTH_REDIRECT_URI=https://app-url/auth/callback
OAUTH_BASE_URL=https://authentic-url
```

If you want to disable authentication just leave OAUTH_PROVIDER empty

To start application run
```
docker compose up
```