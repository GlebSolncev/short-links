# Short links
- php: 7.4.16
- MySQL: 5.7
- nginx: 1.19.10

## Installation

#### Software
- Docker. (Docker version 20.10.5, build 55c4c88)
- Makefile. (GNU Make 3.81)

#### Project set
- Copy .env.example to .env
- Update .env: (DB_DATABASE, DB_PASSWORD). Example: short-link, myrootpassword

#### CLI commands
- make init
  
Build services to application
- make ps
  
for check your services state (if Up and healthy: next commands)
- make migrate
  
migrate table(s) in database

- make up
  
Start work application

You can click link on cli or open http://localhost:8000/short-link


## Other command
- make help

Get help to makefile