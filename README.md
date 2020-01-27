# Cart-witnessing

This application is used to help organize the cart witnessing work for Jehovah's Witnesses.

# Development

## Getting started

```
cat db/structure.sql | mysql -h <mysqlhost> -u <user> -p<password> <database_name>
```

```
PHINX_HOST=<mysqlhost> PHINX_NAME=<database_name> PHINX_USER=<user> PHINX_PASS=<password> vendor/bin/phinx migrate
```