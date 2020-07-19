
I have imposed a fictitious narrative on this relational diagram to aid in my description:  
> The Government of Ontario has a sign-in access portal for employees of any of the Ontario ministries. One interface of this portal allows employees (i.e. users)  to submit issues they identify in their workplace, such as safety hazards or missing equipment. This information is stored in a database as a collection of tables.

The ```issues``` table is the central entity, representing the issues the employees submit. It contains information about the issue with respect to: the ```types``` table, which is a cluster of custom-defined types (see table below) representing factors such as predefined risk ratings (```risk_rating_type_id```), the user who submitted the issue (```user_id```, maps to a row in the ```users``` table), and various descriptive fields about the issue. A row in the ```users``` table represents an employee who has submitted an(y) issue(s).  Given that the rows in the ```types```  table can represent entities across multiple tables and columns, the ```parent_id``` can be used to categorize  ```types``` according to their use case. 

For example, the following could be imposed:

| Table | Column | Parent ID |
|---|---|---|
| issues | issue_type_id | 1 |
| | risk_rating_type_id | 2 |
| | source_type_id | 3 |
| issues_tactics | tactic_type_id | 4 |
  
  
Such that all of the rows in ```types``` with a ```parent_id``` of ```1``` are only to be used in the ```issue_type_id``` column in the ```issues``` table.

The ```issues_ministries``` table keeps a record of pairs of values: issues and the respective ministries they occur in. This offers fast queries if, for example, one wanted to retrieve all the issues associated with a specific ministry. The ```ministry_id``` column maps to the ```ministries``` table which contains the full identity of the ministry associated with the given ```ministry_id```.