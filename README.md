**API FOR TRANSFER FUNDS**

-----------INSTALLATION----------------

You have to be installed `docker && docker-compose && make`.
Also, you should have free ports - 3306, 80. If you can`t free these ports, you have to change it manually in docker-compose.yml

- CLone this repository from github
- Run `make up` from root directory and wait for magic)

----------------TESTING----------------

Script for init tests - 
`make tests`

------------DOCUMENTATION--------------

After `make up` you will have 4 business_logic tables. 
1. users (default table)
2. wallets (users can have a lot of wallets)
3. users_transactions (Here we save all transactions(pending, success, failed))
4. system_transactions (Here we will store commission balance).

1) Upon application start the database should be populated with sample data - 
After `make up` you will get 3 users and 5 wallets to transfer funds between. All wallets have 10000 'coins'.
Minimal amount for transfer  100 coins. You can modify it in 'UserTransaction' constants.   
   
These hashes(every wallet has unique hash) you need to make POST requests to api :
   - g0MJ7HpSRh
   - C4KCmvqNSd
   - qPtljyeLz7 
   - FuvqtPKugf 
   - DOQli16WsW 


2) REST endpoint that can be used to transfer funds -

Method: POST
Request URL: http://localhost/api/transactions
PARAMS:
1. `sender_wallet` => hash(above) -> string 
2. `receiver_wallet` => hash(above) -> string
3. `amount` => sum for transfer -> integer
4. `commission_payer`(optional) -> string. You can choose, who will pay for commission.
It can be `sender`, `receiver`. Default - `sender`.



P.S 
    I know about API Authentication by tokens.I missed it on purpose by your advice.
Also, I skipped `creating user/top-up wallet`. If I did this in real life, I would also add different currencies to wallets.
But you gave me several clean hours for this task, that's why some moments are missed.

P.S 2
    Table `wallet` has custom field `hash`. I made it only for speed development.
This would be relevant if the application was pulled from the outside in order to hide the real `ids`.
Or we can use JWT tokens for 'hiding' data. In the future, I can make free transfers between wallets that belong to the same user.Depends on project)
