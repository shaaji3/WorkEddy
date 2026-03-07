# WorkEddy

Production-oriented implementation of WorkEddy aligned to `requirements.md` stack and architecture.

## Stack alignment from requirements

- **Backend language/runtime:** PHP 8.2+
- **Routing:** FastRoute
- **Logging:** Monolog
- **DB layer:** Doctrine DBAL
- **Auth/JWT:** firebase/php-jwt
- **Queue:** Redis
- **Database:** MySQL 8+
- **Frontend:** Bootstrap 5 + Vanilla JS (+ Alpine.js included)
- **Infra:** Docker Compose + Nginx + API + Worker
- **Storage:** Server filesystem under `/storage/uploads/...`

## Delivered modules

- Authentication and organization onboarding
- User role management (admin/supervisor/worker/observer)
- Task management
- Manual scan engine with normalized risk scoring
- Video scan ingestion + asynchronous queue processing
- MediaPipe-based posture metrics extraction in worker pipeline
- Dashboard analytics
- Observer rating API
- Usage tracking for manual/video scans

## API

Base URL: `/api/v1` (legacy unprefixed routes are also accepted).

- `POST /auth/signup`
- `POST /auth/login`
- `POST /auth/logout`
- `GET /auth/me`
- `GET /users`, `POST /users`
- `GET /tasks`, `POST /tasks`, `GET /tasks/{id}`
- `POST /scans/manual`, `GET /scans`, `GET /scans/{id}`
- `GET /dashboard`
- `POST /observer-rating`
- `GET /health`

## Setup

```bash
docker compose up --build
```

```bash
docker compose exec api composer install
docker compose exec api php scripts/migrate.php migrate
docker compose exec api php scripts/seed.php run
```

## Database Commands

- `php scripts/migrate.php migrate` - apply pending migrations
- `php scripts/migrate.php rollback [batches]` - roll back latest migration batch(es)
- `php scripts/migrate.php status` - list applied/pending migrations
- `php scripts/seed.php run [filter]` - run seeders (use `demo` filter for demo seeders)

## Notes

- All business data endpoints are organization-scoped using JWT claims.
- Role checks are enforced per endpoint.
- Worker service is active for upcoming video pipeline expansion.
