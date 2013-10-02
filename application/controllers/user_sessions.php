<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_sessions
 *
 * @author L745
 */
class user_sessions extends MY_load_controller {

    function __construct() {
        parent::__construct();

        // used in script to determine menu
        $this->load->vars('menu', 'user_sessions');

        // Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
        if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'logout') {
            // Preserve any flashdata messages so they are passed to the redirect page.
            if ($this->session->flashdata('message')) {
                $this->session->keep_flashdata('message');
            }

            // Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
            if ($this->flexi_auth->is_admin()) {
                redirect('welcome');
            } else {
                redirect('welcome');
            }
        }
    }

    /**
     * login
     * Login page used by all user types to log into their account.
     * This demo includes 3 example accounts that can be logged into via using either their email address or username. The login details are provided within the view page.
     * Users without an account can register for a new account.
     * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
     */
    function login() {
        $this->data['content_title'] = "Login";
        $this->data['title'] = $this->load->get_var('web_title') . " - " . $this->data['content_title'];
        // If 'Login' form has been submited, attempt to log the user in.
        if ($this->input->post('login_user')) {
            $this->load->model('user_model');
            $this->user_model->login();
        }

        // CAPTCHA Example
        // Check whether there are any existing failed login attempts from the users ip address and whether those attempts have exceeded the defined threshold limit.
        // If the user has exceeded the limit, generate a 'CAPTCHA' that the user must additionally complete when next attempting to login.
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            /**
             * reCAPTCHA
             * http://www.google.com/recaptcha
             * To activate reCAPTCHA, ensure the 'recaptcha()' function below is uncommented and then comment out the 'math_captcha()' function further below.
             *
             * A boolean variable can be passed to 'recaptcha()' to set whether to use SSL or not.
             * When displaying the captcha in a view, if the reCAPTCHA theme has been set to one of the template skins (See https://developers.google.com/recaptcha/docs/customization),
             *  then the 'recaptcha()' function generates all the html required.
             * If using a 'custom' reCAPTCHA theme, then the custom html must be PREPENDED to the code returned by the 'recaptcha()' function.
             * Again see https://developers.google.com/recaptcha/docs/customization for a template 'custom' html theme. 
             * 
             * Note: To use this example, you will also need to enable the recaptcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            $this->data['captcha'] = $this->flexi_auth->recaptcha(FALSE);

            /**
             * flexi auths math CAPTCHA
             * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
             * For flexibility on CAPTCHA presentation, the 'math_captcha()' function only generates a string of the equation, see the example below.
             * 
             * To activate math_captcha, ensure the 'math_captcha()' function below is uncommented and then comment out the 'recaptcha()' function above.
             *
             * Note: To use this example, you will also need to enable the math_captcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            # $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('shared/head', $this->data);
        $this->load->view('shared/scripts', $this->data);
        $this->load->view('shared/header', $this->data);
        $this->load->view('shared/content_title', $this->data);
        $this->load->view('user_sessions/login', $this->data);
        $this->load->view('shared/footer', $this->data);
    }

    /**
     * logout
     * This example logs the user out of all sessions on all computers they may be logged into.
     * In this demo, this page is accessed via a link on the demo header once a user is logged in.
     */
    function logout() {
        $this->session->unset_userdata('user_data');
        $this->session->unset_userdata('privileges');
        // By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
        $this->flexi_auth->logout(TRUE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('login');
    }

    /**
     * logout_session
     * This example logs the user only out of their CURRENT browser session (e.g. Internet Cafe), but no other logged in sessions (e.g. Home and Work).
     * In this demo, this controller method is actually not linked to. It is included here as an example of logging a user out of only their current session.
     */
    function logout_session() {
        $this->session->unset_userdata('user_data');
        $this->session->unset_userdata('privileges');
        // By setting the logout functions argument as 'FALSE', only the current browser session is logged out.
        $this->flexi_auth->logout(FALSE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('login');
    }

    /**
     * register_account
     * User registration page used by all new users wishing to create an account.
     * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
     */
    function register_account() {
        // Redirect user away from registration page if already logged in.
        if ($this->flexi_auth->is_logged_in()) {
            redirect('login');
        }
        // If 'Registration' form has been submitted, attempt to register their details as a new account.
        else if ($this->input->post('register_user')) {
            $this->user_model->register_account();
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('demo/public_examples/register_view', $this->data);
    }

}

?>
