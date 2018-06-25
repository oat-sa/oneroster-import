[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d8351b7ac84046198c36ca11c7bdcf45)](https://www.codacy.com/app/ionutpad/oneroster-import?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=oat-sa/oneroster-import&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/d8351b7ac84046198c36ca11c7bdcf45)](https://www.codacy.com/app/ionutpad/oneroster-import?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=oat-sa/oneroster-import&amp;utm_campaign=Badge_Coverage)
## Import CSV files using OneRoster V1.1 standard

###### More Information about the standard can be found here:
http://www.imsglobal.org/oneroster-v11-final-csv-tables

The scope of this repository it's to import the file and validate the fields according to v1 standard.
The json configuration of fields can be found in /config/v1/ folder

##### Setup InMemoryStorage

```php
$fileHandler = new FileHandler();
$importService = new ImportService($fileHandler);
$results = $importService->importMultiple(__DIR__ . '/../data/samples/oneRoster1.0/');

$storage = new InMemoryStorage($results);
```

##### Setup CsvStorage

```php
$fileHandler = new FileHandler();
$importService = new ImportService($fileHandler);
$importService->setPathToFolder(__DIR__ . '/../../data/samples/OneRosterv1p1BaseCSV/');

$storage = new CsvStorage($importService);
```

##### Examples of using entities after import.

**1**. Setup Entity Repository
```php
$entityRepository = new EntityRepository($storage, $relationConfig);
```
**2**. Fetching entities
```php

// get all organisation
$orgs = $entityRepository->getAll(Organisation::class);

// get one organisation
$org = $entityRepository->get('12345', Organisation::class);

$org->getId();
//return id of entity
$org->getData();
//return the data after format (array)
```

**3**. Fetching related entities
```php
$oneOrg->getEnrollments();
// return all enrollments assign to organisation.
```
Circular 
```php
$oneOrg === $oneOrg->getClasses()->first()->getOrg();
```
> More information about relations can be found in config/v1/relations.json