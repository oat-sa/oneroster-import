## Import CSV files using OneRoster V1 standard

###### More Information about the standard can be found here: https://www.imsglobal.org/lis/imsOneRosterv1p0/imsOneRosterCSV-v1p0.html#_Toc421598315

The scope of this repository it's to import the file and validate the fields according to v1 standard.
The json configuration of fields can be found in /config/v1/ folder


> Any other meta property can be added to the csv fallowing the format ext_[your_name_space]_[filed_name]
> Please note that for the extra meta properties no validation will be applied.
##### Import Example

```php
$fileHandler = new FileHandler();
$importService = new ImportService($fileHandler);
$results = $importService->importMultiple(__DIR__ . '/../data/samples/oneRoster1.0/');

$storage = new InMemoryStorage($results);
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
$oneOrg === $oneOrg->getClasses()->first()->getOrgs()->first();
```
> More information about relations can be found in config/v1/relations.json