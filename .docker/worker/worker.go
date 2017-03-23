package main

import (
	"github.com/garyburd/redigo/redis"
	"log"
	"time"
	"github.com/messagebird/go-rest-api"
	"encoding/json"
	"strconv"
	"fmt"
)



func main()  {
	redisConn, err := redis.Dial("tcp", "redis:6379")
	if err != nil {
		log.Fatal(err)
	}

	defer redisConn.Close()

	msgBirdClient := messagebird.New("clBHUTYfRaDwHdJl6yy3npYf7")

	for {
		time.Sleep(5	 * time.Second)

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

		fmt.Println(queuedMsg)

		var recipients []string

		for _, item := range queuedMsg.Recipients.Items {
			recipients = append(recipients, strconv.Itoa(item.Recipient))
		}

		messageReceipt, err := msgBirdClient.NewMessage(queuedMsg.Originator, recipients, queuedMsg.Body, params)
		if (err != nil) {
			//log.Fatalf("error: %s", err)
		}

		log.Println(messageReceipt)
	}
}

func getMessageFromQueue(redisConn redis.Conn) ([]byte, error) {
	message, err := redis.Bytes(redisConn.Do("RPOP", "ilpaiijn:api:concatented-sms"))
	if err != nil {
		return []byte{}, err
	}

	return message, nil
}
