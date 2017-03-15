# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
 
### Setup
- `make run`

### Check endpoints
- `http -v http://{dockermachineip}:5000/balances`
- `http -v POST http://{dockermachineip}:5000/messages < data/POST-message.json`