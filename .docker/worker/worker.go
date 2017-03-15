package main

import (
	"github.com/garyburd/redigo/redis"
	"log"
	"time"
	"github.com/messagebird/go-rest-api"
	"encoding/json"
)



func main()  {
	redisConn, err := redis.Dial("tcp", "redis:6379")
	if err != nil {
		log.Fatal(err)
	}

	defer redisConn.Close()

	msgBirdClient := messagebird.New("clBHUTYfRaDwHdJl6yy3npYf7")

	for {
		time.Sleep(1 * time.Second)

		message, err := getMessageFromQueue(redisConn);
		if err != nil {
			log.Println(err)
		}

		if (len(message) == 0) {
			log.Printf("empty message %+v", message)
			continue
		}

		var queuedMsg messagebird.Message

		json.Unmarshal(message, &queuedMsg)

		params := &messagebird.MessageParams{
			Type: queuedMsg.Type,
			TypeDetails: queuedMsg.TypeDetails,
		}

		log.Printf("%+v", queuedMsg)

		messageReceipt, err := msgBirdClient.NewMessage(queuedMsg.Originator, []string{"0034684125308"}, queuedMsg.Body, params)
		if (err != nil) {
			log.Fatalf("error: %s", err)
		}

		log.Fatal(messageReceipt)


	}
}

func getMessageFromQueue(redisConn redis.Conn) ([]byte, error) {
	message, err := redis.Bytes(redisConn.Do("RPOP", "ilpaiijn:api:concatented-sms"))
	if err != nil {
		return []byte{}, err
	}

	return message, nil
}
