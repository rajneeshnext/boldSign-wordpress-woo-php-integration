<?php
    //echo "<pre>";
    $billing_details['billing_first_name'] = "raj";
    $billing_details['billing_last_name'] = "saini";
    $billing_details['billing_email'] = "testingEmail@gmail.com";
    $billing_details['billing_address_1'] = "#222";
    $billing_details['billing_city'] = "mohali";
    $billing_details['billing_state'] = "pb";
    $billing_details['billing_postcode'] = "160052";
    $billing_details['billing_phone'] = $customer_data['phone'] = "98989898989";
    $billing_details['billing_city'] = "mohali";
    
    $customer_data = [
        'first_name'   => $billing_details['billing_first_name'],
        'last_name'   => $billing_details['billing_last_name'],
        'name'    => $billing_details['billing_first_name'] . ' ' . $billing_details['billing_last_name'],
        'email'   => $billing_details['billing_email'],
        'address' => $billing_details['billing_address_1'] . ', ' . $billing_details['billing_city'] . ', ' . $billing_details['billing_state'] . ', ' . $billing_details['billing_postcode'],
        'phone'   => $billing_details['billing_phone'],
    ];
    
    //print_r($customer_data);exit();
    
    // BoldSign API Configuration
    $api_key = 'xxxxxxxxx'; // Replace with your API key
    $template_id = 'xxxxxxxx-a452-4c5e-abcd-6278c3f2d8e9';  // Replace with your template ID
    echo $boldsign_api_url = 'https://api.boldsign.com/v1/template/send?templateId='.$template_id;

    $payload = [
            'templateId' => $template_id,
            'title'      => 'Agreement for ' . $customer_data['first_name'] . ' ' . $customer_data['last_name'],
            'message'    => 'Please review and sign the document.',
            'disableEmails' => false,
            'disableSMS' => true,
            'roles' => [
                [
                    "roleIndex" => 1,
                    'signerName' => $customer_data['first_name'] . ' ' . $customer_data['last_name'],
                    'signerOrder' => 1,
                    'signerEmail' => $customer_data['email'],
                    'privateMessage' => 'Please check and sign the document.',
                    'enableEmailOTP' => false,
                    'signerType' => 'Signer',
                    'signerRole' => 'Customer',
                    'existingFormFields' => [
                        [
                            'id' => 'TextBox9',
                            'value' => $customer_data['first_name'] . ' ' . $customer_data['last_name'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 250,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'EditableDate1',
                            'value' => date('m/d/Y'),
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 100,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox10',
                            'value' => $customer_data['first_name'] . ' ' . $customer_data['last_name'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 250,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox1',
                            'value' => $customer_data['address'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 250,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox2',
                            'value' => $customer_data['suite'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 150,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox3',
                            'value' => $customer_data['city'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 250,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox4',
                            'value' => $customer_data['state'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 200,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox5',
                            'value' => $customer_data['zipcode'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 150,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox6',
                            'value' => $customer_data['country'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 200,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox7',
                            'value' => $customer_data['phone'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 200,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ],
                        [
                            'id' => 'TextBox8',
                            'value' => $customer_data['email'],
                            'bounds' => [
                                'x' => 100,
                                'y' => 100,
                                'width' => 250,
                                'height' => 50
                            ],
                            "pageNumber" => 1,
                            'isRequired' => true
                        ]
                    ],
                    'locale' => 'EN'
                ]
            ],
        ];
    //print_r($payload);
    // cURL Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $boldsign_api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json;odata.metadata=minimal;odata.streaming=true',
        'X-API-KEY: ' . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    //print_r($response);
    $response_data = json_decode($response, true);
    if (!empty($response_data['documentId'])) {
        $documentId = $response_data['documentId'];
        echo '<br/><a href="https://app.boldsign.com/document/sign/?documentId='.$documentId.'">Signature Link</a>';
        $boldsign_api_url = 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$customer_data['email'];
        // Payload for Template-Based Signing
        // cURL Request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $boldsign_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-API-KEY: ' . $api_key,
        ]);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        //print_r($response_data);
        echo '<br/><a href="'.$response_data['signLink'].'">Signature Link</a>';
        echo '<body style="margin:0px;padding:0px;overflow:hidden">
                    <iframe src="'.$response_data['signLink'].'" frameborder="0" style="overflow:hidden;height:300px;width:100%" height="100%" width="100%"></iframe>
                </body>';
        curl_close($ch);
        //wp_send_json_success(['documentId' => $response_data['documentId']]);
    }
    //exit();
?>
