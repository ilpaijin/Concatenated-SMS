# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
 The basic flow is 
### Setup
- `make run`

### Check endpoints
- `http -v http://{dockermachineip}:5000/balances`
- `http -v POST http://{dockermachineip}:5000/messages < data/POST-message.json`