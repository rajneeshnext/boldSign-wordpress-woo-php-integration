<?php
/* Template Name: Thank You 
On Woocomerce Checkout, thank you page ask customer to confirm details and sign the document.
*/
get_header(); ?>
<style>
.thank-you-page{
	width: 90%;
    margin: 0 auto;
}
</style>
<div class="thank-you-page">
	<?php
	if (have_posts()) : 
        while (have_posts()) : the_post();
            the_content();
        endwhile; 
    endif;
    // Check if order key is available
    if (isset($_GET['order_key']) && !empty($_GET['order_key'])) {
        $order_key = sanitize_text_field($_GET['order_key']);
        // Get the order details based on order key
        echo get_order_boldsign_link($order_key);
    } else {
        echo '<p>No order key found.</p>';
    }
    ?>
</div>

<?php 
function get_order_boldsign_link($order_key) {
    if (empty($order_key)) {
        return 'Invalid order key.';
    }
	$order_id = wc_get_order_id_by_order_key($order_key);
    // Get the order object using the order key
    $order = wc_get_order( $order_id );
    if (!$order) {
        return 'Order not found.';
    }
    // Check if the custom field exists
    $boldsign_document = get_post_meta($order->get_id(), 'boldsign_document', true);
    $boldsign_document = "";
	echo "<br/><br/>";
    if (!empty($boldsign_document)) {
        //echo '<br/><br/><br/><h2 class="elementor-heading-title elementor-size-default">Please complete Patient Authorization and Consent Form.</h2>';
        return generateEmbeddedLink($boldsign_document, $order->get_billing_email());
    } else {
        //echo '<h2 class="elementor-heading-title elementor-size-default">Please complete Patient Authorization and Consent Form!</h2>';
        $boldsign_document = "";
        $order_details = [];
        $order_details['order_id'] = $order_id; // Billing first name
        $order_details['billing_first_name'] = $order->get_billing_first_name(); // Billing first name
        $order_details['billing_last_name'] = $order->get_billing_last_name(); // Billing last name
        $order_details['billing_email'] = $order->get_billing_email();//$order->get_billing_email(); // Billing email
        $order_details['billing_phone'] = $order->get_billing_phone(); // Billing phone
        $order_details['billing_state'] = $order->get_billing_state();
        $order_details['billing_address_1'] = $order->get_billing_address_1(); // Billing address 1
        $order_details['billing_city'] = $order->get_billing_city(); // Billing city
        $order_details['billing_country'] = $order->get_billing_country();
        $order_details['billing_postcode'] = $order->get_billing_postcode(); // Billing postcode
        $order_details['billing_suite'] = $order->get_billing_address_2(); // Billing postcode
        $order_details['boldsign_document'] = $boldsign_document; // Billing first name
        return createDocumentLink($order_details);
    }
}
function createDocumentLink($billing_details){
        $customer_data = [
            'first_name'   => $billing_details['billing_first_name'],
            'last_name'   => $billing_details['billing_last_name'],
            'name'    => $billing_details['billing_first_name'] . ' ' . $billing_details['billing_last_name'],
            'email'   => $billing_details['billing_email'],
            'address' => $billing_details['billing_address_1'] . ', ' . $billing_details['billing_city'] . ', ' . $billing_details['billing_state'] . ', ' . $billing_details['billing_postcode'],
            'phone'   => $billing_details['billing_phone'],
            'suite'   => $billing_details['billing_suite'],
            'city'   => $billing_details['billing_city'],
            'zipcode'   => $billing_details['billing_postcode'],
            'state'   => $billing_details['billing_state'],
            'country'   => $billing_details['billing_country'],
        ];
        $order_id = $billing_details['order_id'];
        //echo "<pre>";
        //print_r($customer_data);exit();
        $api_key = 'xxxxxxxx'; // Replace with your API key
        $template_id = 'xxxx-a452-4c5e-xxxxx-xxxxxxx';  // Replace with your template ID
        $boldsign_api_url = 'https://api.boldsign.com/v1/template/send?templateId='.$template_id;
    
        $payload = [
                'templateId' => $template_id,
                'title'      => 'Agreement for ' . $customer_data['first_name'] . ' ' . $customer_data['last_name'],
                'message'    => 'Please review and sign the document.',
                'disableEmails' => false,
                'disableSMS' => true,
                'roles' => [
                    [
                        'roleIndex' => 1,
                        'signerName' => $customer_data['first_name'] . ' ' . $customer_data['last_name'],
                        'signerOrder' => 1,
                        'signerEmail' => $customer_data['email'],
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
        $response_data = json_decode($response, true);
        if(isset($response_data['error'])){
            return $response_data['error'];
        }
        if (!empty($response_data['documentId'])) {
            $documentId = $response_data['documentId'];
            update_post_meta($order_id, 'boldsign_document', $documentId);
            return generateEmbeddedLink($documentId, $customer_data['email']);
        }    
}      
function generateEmbeddedLink($documentId, $email){
    if (!empty($documentId)) {
            $boldsign_api_url = 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$email;
            $api_key = 'xxxxxxxx'; // Replace with your API key
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $boldsign_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-API-KEY: ' . $api_key,
            ]);
            $response = curl_exec($ch);
            $response_data = json_decode($response, true);
            //print_r($response_data);
            curl_close($ch);
            if(isset($response_data['error'])){
                return $response_data['error'];
            }
            return '<iframe src="'.$response_data['signLink'].'" frameborder="0" style="overflow:hidden;height:800px;width:100%" width="100%"></iframe>';
    } 
}
get_footer(); ?>
