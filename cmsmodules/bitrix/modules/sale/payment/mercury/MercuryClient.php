<?php

/**
 * MercuryClient class
 *
 * @author Igor Manturov Jr. <igor.manturov.jr@gmail.com>
 */
class MercuryClient
{

    /**
     * @var string JWT token.
     */
    private $token;

    /**
     * @var string Endpoint URL
     */
    private $url;

    /**
     * @var CurlClient
     */
    private $client;

    //TODO для тестов
    //const ENDPOINT_URL = 'https://gql.mercurypos.online/gql';

    /**
     * MercuryClient constructor.
     *
     * @param string $token JWT token.
     */
    public function __construct($url, $token)
    {
        $this->url     = $url;
        $this->token   = $token;
        $this->client = new CurlClient($this->url, $this->token);

    }


    /**
     * @param array $order
     * @param array $items
     * @param string $phone
     * @param string $address
     * @param string $customerFirstName
     * @param string $customerMiddleName
     * @param string $customerLastName
     * @param string $customerEmail
     * @return Response
     */
    public function createSession($order, $items, $phone = null,  $address = null, $customerFirstName = null, $customerMiddleName = null, $customerLastName = null, $customerEmail = null)
    {
        $orderEncoded = "{";
        !isset($order[ 'amount' ])        ?: $orderEncoded  .= "amount: ${order[ 'amount' ]} ";
        !isset($order[ 'currency' ])      ?: $orderEncoded  .= "currency: \"${order[ 'currency' ]}\" ";
        !isset($order[ 'reference' ])     ?: $orderEncoded  .= "reference: \"${order[ 'reference' ]}\" ";
        !isset($order[ 'tax_amount' ])    ?: $orderEncoded  .= "taxAmount: ${order[ 'tax_amount' ]}";
        $orderEncoded .= "}";

        $itemsEncoded = "[";
        for ($i = 0; $i < count($items); ++$i) {
            $item          = $items[ $i ];
            $itemsEncoded .= "{";
            !isset($item[ 'amount' ])        ?: $itemsEncoded  .= "amount: ${item[ 'amount' ]} ";
            !isset($item[ 'price' ])         ?: $itemsEncoded  .= "price: ${item[ 'price' ]} ";
            !isset($item[ 'name' ])          ?: $itemsEncoded  .= "name: \"${item[ 'name' ]}\" ";
            !isset($item[ 'quantity' ])      ?: $itemsEncoded  .= "quantity: ${item[ 'quantity' ]} ";
            !isset($item[ 'quantity_unit' ]) ?: $itemsEncoded  .= "quantityUnit: \"${item[ 'quantity_unit' ]}\" ";
            !isset($item[ 'reference' ])     ?: $itemsEncoded  .= "reference: \"${item[ 'reference' ]}\" ";
            $itemsEncoded .= "}";
        }
        $itemsEncoded .= "]";

        $mutation = "mutation {
          token: openSession(
            input: {
              order: ${orderEncoded},
              product: ${itemsEncoded} ";
        if (!is_null($address) && $address !== '') {
            $mutation .= ", customerAddress: ${address} ";
        }
        if (!is_null($phone) && $phone !== '') {
            $mutation .= ", customerPhone: ${phone}";
        }

        if(!is_null($customerFirstName) && $customerFirstName !==''){
            $mutation .= ", customerFirstName: ${customerFirstName}";
        }
        if(!is_null($customerMiddleName) && $customerMiddleName !==''){
            $mutation .= ", customerMiddleName: ${customerMiddleName}";
        }
        if(!is_null($customerLastName) && $customerLastName !==''){
            $mutation .= ", customerLastName: ${customerLastName}";
        }
        if(!is_null($customerEmail) && $customerEmail !==''){
            $mutation .= ", customerEmail: ${customerEmail}";
        }



        $mutation .= "})}";
        return $this->client->query($mutation);
    }

}

;
/**
 * Class CurlClient
 */
class CurlClient
{

    private $url;

    private $token;

    /**
     * CurlClient constructor.
     *
     * @param $url
     * @param $token
     */
    public function __construct($url, $token)
    {
        $this->url   = $url;
        $this->token = $token;
    }


    /**
     * @param $query
     * @return Response
     */
    public function query($query)
    {
        $token = $this->token;
        $curl  = curl_init($this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [ "Authorization: Bearer ${token}" ]);
        $response = new Response(curl_exec($curl));
        curl_close($curl);
        return $response;
    }
}


/**
 * Class Response
 */
class Response
{
    private $error = false;

    private $data;


    /**
     * Response constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {


        if ($response === false) {
            $this->error = true;
        } else {
            $data = json_decode($response, true);
            if (!isset($data[ 'data' ][ 'token' ])) {
                $this->error = true;
            } else {
                $this->data = $data;
            }
        }
    }


    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error;
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return token
     */
    public function getToken()
    {
        return $this->getData()[ 'data' ][ 'token' ];
    }
}
