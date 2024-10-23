<?php

const FLASH = 'FLASH_MESSAGES';

const FLASH_ERROR = 'danger';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';

/**
 * Create a flash message
 *
 * @param string $name
 * @param string $message
 * @param string $type
 * @return void
 */
function create_flash_message(string $name, string $message, string $type): void
{
    // remove existing message with the name
    if (isset($_SESSION[FLASH][$name])) {
        unset($_SESSION[FLASH][$name]);
    }
    // add the message to the session
    $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
}


/**
 * Format a flash message
 *
 * @param array $flash_message
 * @return string
 */
function format_flash_message(array $flash_message): string
{
    return sprintf('<div class="alert alert-%s">%s</div>',
        $flash_message['type'],
        $flash_message['message']
    );
}

/**
 * Display a flash message
 *
 * @param string $name
 * @return void
 */
function display_flash_message(string $name): void
{
    if (!isset($_SESSION[FLASH][$name])) {
        return;
    }

    // get message from the session
    $flash_message = $_SESSION[FLASH][$name];

    // delete the flash message
    unset($_SESSION[FLASH][$name]);

    // display the flash message
    echo format_flash_message($flash_message);
}

/**
 * Display all flash messages
 *
 * @return void
 */
function display_all_flash_messages(): void
{
    if (!isset($_SESSION[FLASH])) {
        return;
    }

    // get flash messages
    $flash_messages = $_SESSION[FLASH];

    // remove all the flash messages
    unset($_SESSION[FLASH]);

    // show all flash messages
    foreach ($flash_messages as $flash_message) {
        echo format_flash_message($flash_message);
    }
}

/**
 * Flash a message
 *
 * @param string $name
 * @param string $message
 * @param string $type (error, warning, info, success)
 * @return void
 */
function flash(string $name = '', string $message = '', string $type = ''): void
{
    if ($name !== '' && $message !== '' && $type !== '') {
        // create a flash message
        create_flash_message($name, $message, $type);
    } elseif ($name !== '' && $message === '' && $type === '') {
        // display a flash message
        display_flash_message($name);
    } elseif ($name === '' && $message === '' && $type === '') {
        // display all flash message
        display_all_flash_messages();
    }
}

function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    return $protocol . $host . $requestUri;
}

function redirect_with_message(string $message, string $type=FLASH_ERROR, string $name='upload', string $location='index.php'): void
{
    flash($name, $message, $type);
    header("Location: $location", true, 303);
    exit;
}

function modal($id, $modaltitle, $modalbody, $linkaction, $namepost, $valuepost, $buttonname, $type='no', $delete = true, $filepathtodelete = '')
{
    if ($delete) {
        $type_modal = "
        <form method='post' action='$linkaction' class='col-5'>
            <input type='hidden' name='$namepost' value='$valuepost' >
            <input type='hidden' name='type' value='$type' >
            <input type='hidden' name='filepathtodelete' value='$filepathtodelete' >
            <input type='submit' class='btn btn-primary' value='$buttonname'>
        </form>
    ";
    } else {
        $type_modal = "";
    }
    
    $content = "
    <div class='modal fade' id='$id'  aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>$modaltitle</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            $modalbody
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
            $type_modal
          </div>
        </div>
      </div>
    </div>";
    return $content;
}

function calculateAge($birthDate) {
    if (isset($birthDate)) {
        $d1=strtotime($birthDate);
        $d2= round(((time() - $d1)/(60 * 60 * 24 * 30 * 12)), 1);
        // Convertir la date de naissance en objet DateTime
        return $d2;
    }
    return 0;
}

function recherche_dans_tableau()
{
    $content = "
        <div class='col-md-6'>
            <div class='input-group mb-3'>
                <span class='input-group-text' id='basic-addon1'>Rechercher </span>
                <input type='text' id='recherche' class='form-control' placeholder='Ecrivez faite la recherche ici ...' aria-label='Username' aria-describedby='basic-addon1'>
            </div>
        </div>
    ";
    return $content;
}

function is_user_logged_in(): bool
{
    return isset($_SESSION['username']);
}

function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect_with_message('Vous devez d abord vous connecter', FLASH_ERROR, 'index', "index.php");
    }
}
function get_redirect ()
{
    if(! isset($_GET['q'])) {
        redirect_with_message('Essayez encore', FLASH_ERROR, 'home', "home.php");
    }
}
function logout()
{
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        redirect_with_message('Vous etes maintenant deonnecté', FLASH_SUCCESS, 'index', "index.php");
    }
    redirect_with_message('Vous etes maintenant connecté', FLASH_ERROR, 'home', "home.php");
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }
    return null;
}