# Pulse

A simple Realtime audience feedback application, run as a PWA.  Category: ARS (Audience Response System)

## Use Case

A speaker can create a presentation and share a QR code with the audience.

Audience members can clap, shrug or ask questions during the talk, which the speaker will see in near realtime. (@todo: add mercure).

The application in intentionally simple, as its primary goal is to demonstration how to make a PWA with Symfony.  

## Tech Stack

* Symfony
* Stimulus
* HTMX/HyperScript
* PostgreSQL
* Bootwatch/Sandstone

## Authentication

Only speakers need to log in, to create and manage their talks. 

## 

clone, then


```bash
bin/console d:d:c && bin/console d:m:m -n

bin/create-admins.sh
bin/console app:load-data

```
