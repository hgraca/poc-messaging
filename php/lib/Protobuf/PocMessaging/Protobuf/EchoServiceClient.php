<?php
// GENERATED CODE -- DO NOT EDIT!

namespace PocMessaging\Protobuf;

/**
 */
class EchoServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \PocMessaging\Protobuf\Message $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ping(\PocMessaging\Protobuf\Message $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/PocMessaging.Protobuf.EchoService/ping',
        $argument,
        ['\PocMessaging\Protobuf\Message', 'decode'],
        $metadata, $options);
    }

}
