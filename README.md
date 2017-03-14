# Concatenated SMS

###### Analysing SMS concatenation on MessageBird API
 
### Setup
- `docker-compose -p ilpaijin-concatenatedcsms up --build`

### Check
- `http -v http://{youdockermachineip}:5000/balances`
- `http -v POST http://{youdockermachineip}:5000/messages < data/POST-message.json`