<?php
function SubscribeForm() {
  $form['email'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' =>array('placeholder' => t('E-mail address'))
  );
  $form['first_name'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' => array('placeholder' => t('First Name'))
  );
  $form['last_name'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' => array('placeholder' => t('Last Name'))
  );
  $form['street'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' => array('placeholder' => t('Street address'))
  );
  $form['zip'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' => array('placeholder' => t('Zip Code'))
  );
  $form['city'] = array(
    '#type' => 'textfield',
    '#title' => '',
    '#size' => '20',
    '#attributes' => array('placeholder' => t('City'))
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Subscribe'),
  );
  return $form;
}

function SubscribeForm_validate($form, &$form_state) {
  $valid_email = $form_state['values']['email'];
  $first_name = $form_state['values']['first_name'];
  $last_name = $form_state['values']['last_name'];
  $street = $form_state['values']['street'];
  $zip = $form_state['values']['zip'];
  $city = $form_state['values']['city'];  
  if (!valid_email_address($valid_email)) {
    form_set_error('email', 'Sorry. Your email address,' . $valid_email . ', is not valid. Please submit a valid E-mail address.');
  }
  if(strlen(trim($first_name)) < 1) {
      form_set_error('first_name','Sorry your first name, ' . $first_name . ', is empty. Please provide your first name.');
  }
  if(strlen(trim($last_name)) < 1) {
      form_set_error('last_name','Sorry your last name, ' . $last_name . ', is empty. Please provide your street name.');
  }
  if(strlen(trim($street)) < 1) {
      form_set_error('street','Sorry your street, ' . $street . ', is empty. Please provide your street.');
  }
  if(strlen(trim($zip)) < 1) {
      form_set_error('zip','Sorry your code, ' . $zip . ', is empty. Please provide your zip code.');
  } else if(!is_numeric($zip)) {
      form_set_error('zip','Sorry your zip code, '. $zip . ', must be all numeric. Please provide a valid zip code.');
  }
  if(strlen(trim($city)) < 1) {
      form_set_error('city','Sorry your city, ' . $city . ', is empty. Please provide your city.');
  }
}

function SubscribeForm_mail($key, &$message, $params) {

  $headers = array(
    'MIME-Version' => '1.0',
//    'Content-Type' => 'text/html; charset=UTF-8;',
    'Content-Type' => 'text/plain; charset=UTF-8;',
    'Content-Transfer-Encoding' => '8Bit',
    'X-Mailer' => 'Drupal'
  );

  foreach ($headers as $key => $value) {
    $message['headers'][$key] = $value;
  }

  $message['subject'] = $params['subject'];
  $message['body'] = $params['body'];
}


function SubscribeForm_submit($form, &$form_state) {
    $valid_email = $form_state['values']['email'];
    $from = 'noreply@tampabay.gptoolsflorida.org';
    $body[] = 'Email: '.$valid_email.'<br />';
    $body[] = 'First Name: ' . $form_state['values']['first_name'] . '<br />';
    $body[] = 'Last Name: ' . $form_state['values']['last_name'] . '<br />';
    $body[] = 'Street: ' . $form_state['values']['street'] . '<br />';
    $body[] = 'Zip: ' . $form_state['values']['zip'] . '<br />';
    $body[] = 'City: ' . $form_state['values']['city'] . '<br />';
    $body[] = 'URL: '.request_uri() . '<br />';
    $to = 'tampagreenparty@gmail.com'; // Set this email address - emails will be sent to this email address! 
    $params = array(
    'body' => $body,
    'subject' => 'Sign up for our e-mail list and get information about the Green Party in Tampa',
    );

    if (drupal_mail('SubscribeForm', 'some_mail_key', $to, language_default(), $params, $from, TRUE))
    {
        drupal_set_message('Thanks, we will be in contact with more information soon.');     
    } else {
        drupal_set_message('There was an error subscribing you. Please try again later');
    }
}
return drupal_render(drupal_get_form('SubscribeForm')); 
?>