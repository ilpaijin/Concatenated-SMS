package main

import (
	"fmt"
	"github.com/garyburd/redigo/redis"
	"log"
	"time"
)

func main()  {
	redisConn, err := redis.Dial("tcp", "redis:6379")
	if err != nil {
		log.Fatal(err)
	}

	defer redisConn.Close()

	for {
		time.Sleep(1 * time.Second)
		showList(redisConn)
	}
}

func showList(redisConn redis.Conn) {
	list, err := redis.String(redisConn.Do("RPOP", "ilpaiijn:api:concatented-sms"))
	if err != nil {
		log.Println(err)
	}

	fmt.Println(list)
}
