## Horizon application monitoring separate laravel application queue workers

A boilerplate application to test horizon monitoring for multiple applications. In example we have 2 applications cms-app and website-app. Cms app has 2 workers. One is listening to main queue, another is listening for long running jobs queue. Website has only single worker with single queue.

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

Example to deploy via helm with base chart
```
image:
  repository: dasmeta/horizon-monitor
  tag: 0.0.2
  pullPolicy: IfNotPresent

product: your-product-name

secretsDefaultEngine: disabled

labels:
  label1:
    name: "app-version"
    value: "v0.0.2"

autoscaling:
  enabled: true
  minReplicas: 1
  maxReplicas: 1
  targetCPUUtilizationPercentage: 70
  targetMemoryUtilizationPercentage: 70

containerPort: 8000

service:
  enabled: true
  name: http
  type: NodePort
  port: 80
  protocol: TCP
  annotations:
    linkerd.io/inject: enabled

ingress:
  enabled: true
  class: alb
  annotations:
    alb.ingress.kubernetes.io/group.name: ingress
    alb.ingress.kubernetes.io/certificate-arn: arn
  hosts:
    - host: horizon.test.com
      paths:
        - path: /
          pathType: Prefix
          backend:
            service:
              name: horizon
              port: 80

config:
  APP_NAME: horizon
  APP_ENV: local
  APP_KEY: base64:xxx
  APP_DEBUG: true
  APP_URL: https://horizon.test.com
  APP_LOCALE: en
  APP_FALLBACK_LOCALE: en
  APP_FAKER_LOCALE: en_US
  APP_MAINTENANCE_DRIVER: file
  PHP_CLI_SERVER_WORKERS: 4
  BCRYPT_ROUNDS: 12
  LOG_CHANNEL: stack
  LOG_STACK: single
  LOG_DEPRECATIONS_CHANNEL: "null"
  LOG_LEVEL: debug
  DB_CONNECTION: sqlite
  DB_DATABASE: /mnt/sqlite/database.sqlite
  SESSION_DRIVER: database
  SESSION_LIFETIME: 120
  SESSION_ENCRYPT: false
  SESSION_PATH: /
  SESSION_DOMAIN: "null"
  BROADCAST_CONNECTION: log
  FILESYSTEM_DISK: local
  CACHE_STORE: database
  QUEUE_CONNECTION: redis
  REDIS_HOST: redis
  HORIZON_PREFIX: "shared_horizon:"
  VITE_APP_NAME: horizon
  OAUTH_PROVIDER=authentik
  OAUTH_CLIENT_ID=autentik-client-id
  OAUTH_CLIENT_SECRET=authentik-client-secret
  OAUTH_REDIRECT_URI=https://horizon.test.com/auth/callback
  OAUTH_BASE_URL=https://authentik.test.com

storage:
  - persistentVolumeClaimName: storage-horizon
    accessModes:
      - ReadWriteMany
    className: efs-sc-root
    requestedSize: 1G
    enableDataSource: false

volumes:
  - name: storage-horizon-volume
    mountPath: /mnt/sqlite
    persistentVolumeClaim:
      claimName: storage-horizon