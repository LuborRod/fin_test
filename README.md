**API FOR TRANSFER FUNDS**

-----------INSTALLATION----------------

You have to be installed `docker && docker-compose && make`.
Also, you should have free ports - 3306, 80. If you can`t free these ports, you have to change it manually in docker-compose.yml

- CLone this repository from github
- Run `make init` from root directory and wait for magic)

------------DOCUMENTATION--------------

After `make init` you will have 4 business_logic tables. 
1. users (default table)
   
2. wallets (users can have a lot of wallets)
   
3. users_transactions (Here we save all users transactions)

4. system_transactions (Here we will store commission balance).

1) Upon application start the database should be populated with sample data - 
After `make init` you will get 3 users and 6 wallets to transfer funds between. All wallets have 1 000 000 000 'Satoshi'(10 BTC).
   
Minimal amount for transfer  - 0.00000001. 
Maximal amount for transfer  - 10000. 
   
You can modify it in 'UserTransaction' constants.   
   
These hashes(every wallet has unique hash) you need to make POST requests to api :
   - g0MJ7HpSRh
   - C4KCmvqNSd
   - qPtljyeLz7 
   - FuvqtPKugf 
   - DOQli16WsW 
   - DOQli27WsW 


2) REST endpoint that can be used to transfer funds -

Method: POST
Request URL: http://localhost/api/transactions
PARAMS:
1. `sender_wallet` => hash(above) -> string 
2. `receiver_wallet` => hash(above) -> string
3. `amount` => sum for transfer -> integer|float. BTC
4. `commission_payer`(optional) -> integer. You can choose, who will pay for commission.
It can be `1 => sender`, `2 => receiver`. Default - 1(sender).



P.S 
    I know about API Authentication by tokens.I missed it for speed. Also, I didn't open 443 port for HTTPS.
I skipped `creating user/top-up wallet`. If I did this in real life, I would also add different currencies to wallets.
But you gave me several clean hours for this task, that's why some moments are missed.

P.S 2
    Logging was also skipped. I wrote commentaries.Table `wallet` has custom field `hash`. I made it only for speed development.
This would be relevant if the application was pulled from the outside in order to hide the real `ids`.
Or we can use JWT tokens for 'hiding' data. In the future, I can make free transfers between wallets that belong to the same user.Depends on project).
For your convenience I delete .env from .gitignore). Own custom exceptions for every case are also welcome.)
