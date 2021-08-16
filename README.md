# BDI ² CMS (Black Dog Institutes, Basic Data Interactor)

* Single line input should be declared as type `varchar`. Multiline as `text`. This will help distinguish input types.

## Todo:
* how to handle text & varchar & max or min length?
* how to handle RTE or markdown (https://simplemde.com/, https://github.com/sparksuite/simplemde-markdown-editor)?
* how to handle setting one to many fk relationships?
* data validation.
* data tidying before entry (use PDO instead).

**Exporting seed data**
* add ability to export SQL statements for all tables & data.
* add ability to track update statements & export only those after the last export. Do this by adding all update statements to a table & marking with a version each time "export" is clicked.
* add ability to export entire db file.

