---
title: 'Convert MySQL CLI Output to Markdown'
---

Ever deal with raw SQL output, and need to put it in a prettier format quickly? Here's a trick to get it nice, fast.

---
```
mysql> select * from tsocsensoreventtypestats WHERE Tenant = 'zzthing'  AND Occurred >= '2019-08-29 00:30:00';
+---------+---------------------+----------------------------+-----------+-------+
| Tenant  | Occurred            | Sensor                     | EventType | Count |
+---------+---------------------+----------------------------+-----------+-------+
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | ASA       |     1 |
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | Unknown   |     2 |
+---------+---------------------+----------------------------+-----------+-------+
2 rows in set (0.01 sec)
```
---

First, remove the top and bottom lines:
```
| Tenant  | Occurred            | Sensor                     | EventType | Count |
+---------+---------------------+----------------------------+-----------+-------+
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | ASA       |     1 |
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | Unknown   |     2 |
```

Second, switch the <kbd>+</kbd> to <kbd>|</kbd>
```
| Tenant  | Occurred            | Sensor                     | EventType | Count |
|---------|---------------------|----------------------------|-----------|-------|
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | ASA       |     1 |
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | Unknown   |     2 |
```
Now, it's working. For bonus points, add a codefence around your SQL:

#### Converted:


```sql
mysql> select * from tsocsensoreventtypestats WHERE Tenant = 'zzthing'  AND Occurred >= '2019-08-29 00:30:00';
```

| Tenant  | Occurred            | Sensor                     | EventType | Count |
|---------|---------------------|----------------------------|-----------|-------|
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | ASA       |     1 |
| zzthing | 2019-08-29 00:30:00 | zzthing-asa-x-unstructured | Unknown   |     2 |