# BDI ² CMS (Black Dog Institutes, Basic Data Interactor)

This is a very simple proof of concept CMS system that can open any SQLite database file and allow users to insert, edit and delete rows from it.
Simply replace `/db/app_database.sqlite` with the desired database and away you go.

It was developed in ~ 6 hours for the BDI innovation day in Q2 2021.

## Exporting data
Anytime a change is made to the database, the relevant query is stored in a table. All change queries can be exported by clicking `Export -> Export All Changes`.
To simply export insert statements for all data currently in the database, click `Export -> Export All Data`.


## Notes
* Due to limitations in Sqllite, all text input fields are being displayed as markdown inputs.
* There is currently no data validation before saving or deleting data.


