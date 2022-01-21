<?php
// GENERATED CODE -- DO NOT EDIT!

namespace PocMessaging\Protobuf;

/**
 */
class EchoServiceStub {

    /**
     * @param \PocMessaging\Protobuf\Message $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \PocMessaging\Protobuf\Message for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function ping(
        \PocMessaging\Protobuf\Message $request,
        \Grpc\ServerContext $context
    ): ?\PocMessaging\Protobuf\Message {
        $context->setStatus(\Grpc\Status::unimplemented());
        return null;
    }

    /**
     * Get the method descriptors of the service for server registration
     *
     * @return array of \Grpc\MethodDescriptor for the service methods
     */
    public final function getMethodDescriptors(): array
    {
        return [
            '/PocMessaging.Protobuf.EchoService/ping' => new \Grpc\MethodDescriptor(
                $this,
                'ping',
                '\PocMessaging\Protobuf\Message',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
        ];
    }

}
