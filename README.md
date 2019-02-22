# api_server

## Get started
```
$ make build    # for docker containers build
# note: the first build will take time on installing gcc and g++
$ make run      # run the containers
```

### Helpers
```
$ make enter    # ssh to the app container
$ make install  # to install dependencies
```


### XDebug
```
# run this 
$ sudo ip addr add 10.0.2.2/24 dev lo label lo:1
```