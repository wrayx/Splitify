# Website Structure

All the alert messages are managed by `alert.php` and all the access right and website title are managed in `header.php`.

![alert](/assets/alert.png)

## index.php

Index page displays user infomation including username and email address.

**First part** of overview displays the percentage of the bill completion that was created by current user.
e.g. bill shared by 4, if 1 has paid the bill then the percentage will be raised to 25%. Click on the icon on the right will direct user to the bills page and user will be able to see the individuals that haven't complete the payment and settings to the bill.

**Second part** of Overview displays the bills waiting for current user to complete. Click on the table row will direct user to the bills page to complete the payment.

![index](/assets/index.png)

## bills.php

This page is the main manegement panel for bills.

**First card** on the page is used to create new bill. User can enter

- Bill name (only alphabetical, numbers and spaces are allowed)
- Amount
- Group to share with
- Choose wether the current user has already paid the bill

![bills-input](/assets/bills-input.png)

Once the bill has been created, there will be an email notification send to each user.

![bills-email-noti](/assets/bills-email-noti.png)

**Second card** is used to display the unpaid bills

- Bill name
- Payee that is waiting for the payment
- Date the bill's creation
- Amount user need to pay
- Button direct user to complete the bill
  - A modal will fall down to simulate the payment process

**Third part** displays the pending payments that was created by the current user. User will be able to delete the bill and confirm the bill if the payment has already been completed personally via other methods.

- Bill name
- Payer : user that haven't complete the payment
- Bill creation Date
- Amount after splitted
- button the confirm the bill that has already been complete via other way

![bills](/assets/bills.png)

## history.php

History payment made by the current user

![history](/assets/history.png)

## groups.php

**First part** used to create group.

- Input name
- Valid members username or email

![groups-input](/assets/groups-input.png)

**Second part** The remaining cards are the groups that includes the current user. User can remove the member and delete group at anytime, this will not affect the bills that has already been created and shared.

![groups](/assets/groups.png)

## account.php

**First part** displays user infomation
![account-info](/assets/account-info.png)
**Second part** user will be able to change their

- username
- email address
- password

![account-change](/assets/account-change.png)

## pwd_recover.php and pwd_reset.php

Those two pages are used to help user to reset their password. User will be authenticate by recieving an email with url to reset password. The url will be verified by selector and token stored in our database, but can expired in few minutes time.
![recover-pwd](/assets/recover-pwd.png)

Email recieved by user

![pwd-reset-email](/assets/pwd-reset-email.png)
