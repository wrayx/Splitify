## CS139 Coursework Assignment

You will be developing BillSplitter! (Please feel free to come up with your own awesome application names). The basic functionality for this application should be as follows:

* User registration
	* Minimum to include: name, email, password
* User authentication
	* Minimum to include: email, password (including secure password storage)
* Adding a bill
	* Minimum to include: name, amount
* Splitting the bill between relevant parties
* Settling payment between parties
* Displaying the status of bills
	* Minimum to include: pending/paid, balances
* Notification of a new bill, and monies owed

### Possible ideas for additional features:
* Email notification
* Person to person bill splitting (e.g. a dinner split between a subset of the house)
* Proportional bill splitting

### Bill
* id
- payee 收款人
- reciept photo 
- amount
- name
- payers 付款人
- numOfPayers
- status (integer between 0-100)

### SplittedBill
- id
- parentbill (foreign bill id)
- payer付款人
- amount
- status (boolean)

### Group
- id
- name
- people