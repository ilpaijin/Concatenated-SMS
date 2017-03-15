FROM scratch
ADD ./worker /
CMD ["/worker", "&"]

#FROM golang:1.7
#
#RUN mkdir -p /go/src/github.com/ilpaijin/concatenated-sms
#
#COPY ./worker.go /go/src/github.com/ilpaijin/concatenated-sms

#RUN go install /go/src/github.com/ilpaijin/concatenated-sms/worker.go

#ENTRYPOINT /go/bin/worker