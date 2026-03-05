<?php
return [
    "driver" => "redis",
    "host" => getenv("REDIS_HOST") ?: "127.0.0.1",
    "port" => (int)(getenv("REDIS_PORT") ?: 6379),
    "queue" => getenv("WORKER_QUEUE") ?: "scan_jobs",
];
