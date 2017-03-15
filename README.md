# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
The points of this demo is to play with:
- using docker-compose 
- using MessageBird API's (both Php and Golang)
- using Redis as a messages queue
- using Php for API entirely from scratch
- using Golang for the messages worker
- play with SMS concatenation and UDH 
- play with services handling

#### Setup
`make run`

#### Check endpoints
- `http -v http://{dockermachineip}:5000/balances`
- `http -v http://{dockermachineip}:5000/messages`

#### Send messages
- `http -v POST http://{dockermachineip}:5000/messages < data/POST-message.json`