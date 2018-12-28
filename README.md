# NoDB
NoDB is a PHP library for users who can't use MySQL

## Types of databases
##### NoDB Provides 4 types of database: default, ColumnSplit, TableSplit and DbSplit.

### Default
##### Default database uses a single .db file, useful for small projects that require medium speed.
##### If a part of the database is corrupted, the whole database will lose the information.

### TableSplit
##### Tablesplit divides the database into as many files as the tables, useful for projects that require high speed and medium-low sotrage usage.
##### If a part of the database is corrupted, only the single table will lose the information

### ColumnSplit
##### Tablesplit divides the database into as many files as columns, useful for projects that require high read speed and reliability.
##### The reading of the data will be reliable and fast, the slowness of writing depends on the number of columns.
##### The number of columns also affects the occupied space. 5 tables = 5 times the space that would occupy a default database

### DbSplit
##### DbSplit divides the database into many parts and uses a map file. Useful for projects that require saving lots of data.
##### Fast writing and slow average reading.

### Automatic Mode (!)
##### The automatic mode combines all types of databases to get the best solution.
##### Not recommended for specific projects, useful only for mixed and temporary projects.
##### Extremely discouraged for projects that require large amounts of data storage.
##### Possible data loss when adding or reading data.