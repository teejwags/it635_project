# IT635 Music Database Project
Author: Theodore J. Wagner, Jr.

IT635 Spring 2020

### Overview
This project consists of three components:
1. The *music* database
2. A web front end for entering into and querying from the database
3. An adminer instance, to inspect the database

To bring up the project, simply clone this GitHub repo and run `docker-compose up`

Once it has been brought up, you can access the following:
- Adminer is available on port **8080** of the *Docker IP*
- The web front end is available on port **8880** of the *Docker IP*

### Database
The *music* database consists of the following tables:
1. *artists* (contains artist name and genre)
2. *catalog* (contains ID, artist name, type (either song or album), song title, album title, and year)
3. *collaborations* (contains ID and collaborator)
4. *certifications* (contains ID and certification)

Relationships between the tables exist as follows:
- *artists* and *catalog* are related through artist name
- *catalog* and *collaborations* are related through ID
- *catalog* and *certifications* are related through ID

For simplicity, the albums in *catalog* are only the artists' studio albums and the certifications in *certifications* are only RIAA certifications.

### Web Front End
The web front end consists of two halves:

#### Entry
This is where you can enter new data into any of the tables of the *music* database.

The necessary data for each *input* is asked for of the user.

#### Query
This is where you can run queries on the *music* database.

There are a total of 20 queries that have been designed.
- The first 10 queries are centric on the *catalog* table, and are useful if considering the database as a listener of music
- The second 10 queries are centric on the *certifications* table, and are useful if considering the database as a music producer

Each query is given a short description of what it will be retrieving, as well as asking the user for appropriate input.

The output page for each query shows the SQL statement that was run.

### Adminer
The credentials you should use to access the database in adminer are:
- username: *root*
- password: *root*
- database: *music*

All other options on the adminer login page can remain the default.

### Author Note
The artists that I have included in the database are some of the ones that I enjoy listening to, and some which I knew would provide a lot of relevant data for use in the queries.
The data was all also entered manually (see the *dump* query to see how many records are in the *catalog* table, all entered by hand).
I hope you enjoy this project as much as I did writing it!
