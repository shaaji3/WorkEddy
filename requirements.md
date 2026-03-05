# WorkEddy – Full Production Software Engineering Specification

Version: 1.0
Audience: Software Engineers, ML Engineers, DevOps, Product

---

# 1. Product Overview

WorkEddy is a SaaS platform designed to detect ergonomic and musculoskeletal risk factors in warehouse and logistics work environments.

The system allows organizations to perform **task risk scans** using two input sources:

1. Manual ergonomic task input
2. Video-based posture analysis

Both pipelines generate standardized ergonomic risk scores used for prevention, analytics, and research validation.

The platform supports:

* Multi-organization SaaS deployment
* Usage-based billing
* Worker task scanning
* Observer validation workflows
* Risk monitoring dashboards

---

# 2. Product Principles

System design follows these principles:

1. Input methods must remain independent
2. Risk scoring must be normalized
3. Processing must be asynchronous
4. System must scale horizontally
5. Privacy-first video handling
6. Transparent risk scoring

---

# 3. Core Functional Modules

The system consists of the following modules.

1 Authentication
2 Organization Management
3 User Management
4 Task Management
5 Scan Engine
6 Video Processing Pipeline
7 Risk Scoring Engine
8 Observer Rating Module
9 Dashboard & Analytics
10 Billing & Usage Tracking

---

# 4. System Architecture

High level architecture:

Client Applications

Web App (Bootstrap 5)
Mobile Browser Interface

Backend Services

API Server (PHP)
Video Processing Workers (Python)
Risk Engine

Infrastructure

MySQL Database
Redis Queue
Server File Storage (local or mounted network storage)

Architecture Diagram

Client
|
v
API Server (PHP)
|
+------ MySQL
|
+------ Redis Queue
|
+------ File Storage (/storage/uploads)

Worker Cluster (Python)
|
v
Pose Analysis Engine
|
v
Risk Scoring Engine

---

# 5. Technology Stack

Frontend

HTML Bootstrap 5 Vanilla JavaScript Fetch API Alpine.js

Backend

Language: PHP 8.2+
API Style: REST
Framework Style: Modular Plain PHP (no full framework)

Core Libraries

Routing

* FastRoute

Logging

* Monolog

Database Layer

* Doctrine DBAL (query builder + connection management)

Authentication

* firebase/php-jwt

Dependency Management

* Composer

These libraries provide a lightweight but production-grade backend stack while avoiding heavy frameworks.

Video Processing

Language: Python

Libraries:

OpenCV
MediaPipe Pose
NumPy
SciPy

Database

MySQL 8+

Queue

Redis

File Storage

Server-side filesystem storage.

Used for:

Video uploads
Processing artifacts
Temporary frames

Files stored under `/storage/uploads` and `/storage/processing`.

Infrastructure

Docker
Docker Compose
Nginx

---

# 6. SaaS Multi‑Tenant Model

The system operates as a multi-tenant SaaS platform.

Each customer is an Organization.

Tenant isolation method:

Shared database
Organization ID scoped data

All major tables include:

organization_id

---

# 7. Roles and Permissions

Roles

Admin
Supervisor
Worker
Observer

Admin Permissions

Manage organization
Manage users
View analytics
Manage billing

Supervisor Permissions

Create tasks
Run scans
View task reports

Worker Permissions

Perform scans
View personal scan results

Observer Permissions

Rate scans
Add ergonomic notes

---

# 8. Authentication System

Authentication uses secure token-based login.

Signup Flow

User registers
Organization created
User becomes Admin

Fields

name
email
password
organization_name

Login Flow

email
password

Security

Password hashing: bcrypt
Session token: JWT

Optional

2FA via OTP

---

# 9. Usage-Based Pricing Model

The system charges organizations based on **scan usage**.

A scan counts when:

Manual scan submitted
Video scan processed successfully

Pricing Model Example

Starter Plan

100 scans per month

Professional

500 scans per month

Enterprise

Unlimited scans

Usage Tracking Table

usage_records

Fields

id
organization_id
scan_id
usage_type
created_at

Billing Cycle

Monthly usage aggregation

---

# 10. Dashboard

The dashboard provides high-level insights.

Metrics

Total scans
High risk tasks
Moderate risk tasks
Risk distribution

Charts

Scan trends
Risk distribution
Department risk heatmap

---

# 11. Task Management

Tasks represent real-world activities performed by workers.

Example

Loading boxes
Sorting packages
Pallet stacking

Task Fields

id
organization_id
name
description
department
created_at

---

# 12. Scan System

A scan represents a risk assessment event.

Two scan types exist.

Manual Scan
Video Scan

Scan lifecycle

Created
Processing (video only)
Completed
Invalid

---

# 13. Manual Scan Engine

Manual scans use structured ergonomic questionnaires.

Fields

weight_lifted
lift_frequency
task_duration
trunk_flexion_estimate
twisting
repetition_rate
overhead_work

Manual Risk Algorithm

Example

score =
(weight_factor * weight)
+
(frequency_factor * repetition)
+
(duration_factor * duration)
+
(posture_factor * trunk_flexion)

---

# 14. Video Scan Workflow

Video Scans follow asynchronous processing.

Steps

1 Worker records video
2 Video uploaded
3 Job queued
4 Worker processes job
5 Pose estimation
6 Posture metrics calculated
7 Risk score generated
8 Scan marked complete

---

# 15. Pose Estimation Engine

Pose detection extracts human skeletal landmarks.

Landmarks

Head
Neck
Shoulders
Elbows
Wrists
Hips
Knees
Ankles

Frame Processing

Video decoded
Frames sampled
Pose estimation applied
Joint angles computed

Frame Sampling

Process every 4th frame to reduce load.

---

# 16. Posture Metrics

Derived metrics include:

max_trunk_angle
avg_trunk_angle
shoulder_elevation_duration
repetition_count
time_in_high_risk_posture

---

# 17. Risk Scoring Engine

Video metrics are translated into risk scores.

Example

Trunk angle > 60° = +30 points
Shoulder elevation > 30% time = +20
High repetition = +15

Scores normalized to:

0 – 100

---

# 18. Repeat Scan Tracking

Scans may reference earlier scans.

Example

scan_A = baseline
scan_B = after correction

System computes improvement delta.

---

# 19. Observer Validation Module

Observers provide expert ratings.

Used for research comparison.

Fields

observer_score
observer_category
notes

---

# 20. Database Schema

organizations

id
name
plan
created_at

users

id
organization_id
name
email
password_hash
role
created_at

plans

id
name
scan_limit
price

subscriptions

id
organization_id
plan_id
start_date
end_date
status

tasks

id
organization_id
name
description
department
created_at

scans

id
organization_id
user_id
task_id
scan_type
raw_score
normalized_score
risk_category
parent_scan_id
status
video_path
created_at

manual_inputs

scan_id
weight
frequency
duration
trunk_angle_estimate
twisting
overhead
repetition

video_metrics

scan_id
max_trunk_angle
avg_trunk_angle
shoulder_elevation_duration
repetition_count
processing_confidence

observer_ratings

id
scan_id
observer_id
observer_score
observer_category
notes

usage_records

id
organization_id
scan_id
usage_type
created_at

---

# 21. API Design

Auth

POST /auth/signup
POST /auth/login
POST /auth/logout

Tasks

POST /tasks
GET /tasks
GET /tasks/{id}

Scans

POST /scans/manual
POST /scans/video
GET /scans/{id}
GET /scans

Observer

POST /observer-rating

Dashboard

GET /dashboard

---

# 22. Video Processing Workers

Workers poll Redis queue.

Job payload

scan_id
video_path

Worker steps

Read video from server storage path
Extract frames
Run pose estimation
Calculate posture metrics
Generate risk score
Update scan record

---

# 23. Storage Design (Server File Storage)

Videos and processing artifacts are stored directly on the application server filesystem or on a mounted storage volume.

Directory Structure

/storage

uploads/

videos/

processed/

frames/

reports/

Storage Strategy

* Uploaded videos stored in `/storage/uploads/videos`
* Extracted frames stored temporarily in `/storage/uploads/frames`
* Processing outputs stored in `/storage/uploads/processed`

Privacy Handling

* Videos are not publicly accessible
* Access is controlled through authenticated API endpoints

Video Retention

Raw videos can be automatically deleted after processing depending on policy.

---

# 25. DevOps Architecture

Infrastructure components

Nginx
PHP API containers
Python worker containers
MySQL
Redis
server storage

Deployment via Docker Compose initially.

---

# 26. Scaling Strategy

API servers scale horizontally.

Video processing workers scale independently.

Queue buffers processing load.

Server-side file storage used for persistence.

---

# 27. Logging

Centralized logs recommended.

Logs

API logs
Worker logs
Processing logs
Security logs

---

# 28. Testing Strategy

Unit Tests

Risk scoring engine
API validation

Integration Tests

Manual scan workflow
Video scan workflow

Load Testing

Video processing queue
Concurrent scan submissions

---

# 29. Development Workflow

Repository structure

/api
/workers
/frontend
/docs

Branch strategy

main
staging
develop

Pull request reviews required.

---

# 30. Initial Development Milestones

Milestone 1

Authentication
Organizations
User roles

Milestone 2

Task management
Manual scan engine
Dashboard

Milestone 3

Video upload
Queue system
Worker processing

Milestone 4

Observer validation
Usage billing
Analytics

#

---

END OF DOCUMENT
