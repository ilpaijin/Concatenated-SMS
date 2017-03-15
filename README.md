# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
The points of this demo is to:
- play with SMS concatenation and UDH 
- using MessageBird API's (both Php and Golang)
- using Docker Compose 
- using Redis as a messages queue
- using Php for API (written entirely from scratch)
- using Golang for the messages worker

#### Setup
`make run`

#### Check endpoints
- `http -v http://{dockermachineip}:5000/balances`
- `http -v http://{dockermachineip}:5000/messages`

#### Send messages
- `http -v POST http://{dockermachineip}:5000/messages < data/POST-message.json`