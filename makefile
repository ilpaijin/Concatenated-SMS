run : build_worker build_docker

build_worker :
	CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o .docker/worker/worker ./.docker/worker/worker.go

build_docker :
	docker-compose -p ilpaijin-concatenatedsms up --build --force-recreate
