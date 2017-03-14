# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
 
### Setup
- `docker-compose -p ilpaijin-concatenatedcsms up --build`

### Check
- `http -v http://{dockermachineip}:5000/balances`
- `http -v POST http://{dockermachineip}:5000/messages < data/POST-message.json`