<?php
/**
 * @copyright Copyright (c) 2015, Google Inc.
 * @link      https://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require __DIR__ . '/appengine-https.php';

 // Initiate the autoloader. The file should be generated by Composer.
// You will provide your own autoloader or require the files directly if you did
// not install via Composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = '';
$secret = '';

// Copy the config.php.dist file to config.php and update it with your keys to run the examples
if ($siteKey == '' && is_readable(__DIR__ . '/config.php')) {
    $config = include __DIR__ . '/config.php';
    $siteKey = $config['v2-standard']['site'];
    $secret = $config['v2-standard']['secret'];
}

// reCAPTCHA supports 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'en';
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,minimum-scale=1">
<link rel="shortcut icon" href="https://www.gstatic.com/recaptcha/admin/favicon.ico" type="image/x-icon"/>
<link rel="canonical" href="https://recaptcha-demo.appspot.com/recaptcha-v2-checkbox.php">
<script type="application/ld+json">{ "@context": "http://schema.org", "@type": "WebSite", "name": "reCAPTCHA demo - \"I'm not a robot\" checkbox", "url": "https://recaptcha-demo.appspot.com/recaptcha-v2-checkbox.php" }</script>
<meta name="description" content="reCAPTCHA demo - &quot;I'm not a robot&quot; checkbox" />
<meta property="og:url" content="https://recaptcha-demo.appspot.com/recaptcha-v2-checkbox.php" />
<meta property="og:type" content="website" />
<meta property="og:title" content="reCAPTCHA demo - &quot;I'm not a robot&quot; checkbox" />
<meta property="og:description" content="reCAPTCHA demo - &quot;I'm not a robot&quot; checkbox" />
<link rel="stylesheet" type="text/css" href="/examples.css">
<title>reCAPTCHA demo - "I'm not a robot" checkbox</title>

<header>
    <h1>reCAPTCHA demo</h1><h2>"I'm not a robot" checkbox</h2>
    <p><a href="/">↤ Home</a></p>
</header>
<main>
<?php
if ($siteKey === '' || $secret === ''):
?>
    <h2>Add your keys</h2>
    <p>If you do not have keys already then visit <kbd> <a href = "https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a></kbd> to generate them. Edit this file and set the respective keys in the <kbd>config.php</kbd> file or directly to <kbd>$siteKey</kbd> and <kbd>$secret</kbd>. Reload the page after this.</p>
    <?php
elseif (isset($_POST['g-recaptcha-response'])):
    // The POST data here is unfiltered because this is an example.
    // In production, *always* sanitise and validate your input'
    ?>
        <h2><kbd>POST</kbd> data</h2>
        <kbd><pre><?php var_export($_POST);?></pre></kbd>
        <?php
    // If the form submission includes the "g-captcha-response" field
    // Create an instance of the service using your secret
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

    // If file_get_contents() is locked down on your PHP installation to disallow
    // its use with URLs, then you can use the alternative request method instead.
    // This makes use of fsockopen() instead.
    //  $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());

    // Make the call to verify the response and also pass the user's IP address
    $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                      ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
    if ($resp->isSuccess()):
        // If the response is a success, that's it!
        ?>
        <h2>Success!</h2>
        <kbd><pre><?php var_export($resp);?></pre></kbd>
        <p>That's it. Everything is working. Go integrate this into your real project.</p>
        <p><a href="/recaptcha-v2-checkbox.php">⟳ Try again</a></p>
        <?php
    else:
        // If it's not successful, then one or more error codes will be returned.
        ?>
        <h2>Something went wrong</h2>
        <kbd><pre><?php var_export($resp);?></pre></kbd>
        <p>Check the error code reference at <kbd><a href="https://developers.google.com/recaptcha/docs/verify#error-code-reference">https://developers.google.com/recaptcha/docs/verify#error-code-reference</a></kbd>.
        <p><strong>Note:</strong> Error code <kbd>missing-input-response</kbd> may mean the user just didn't complete the reCAPTCHA.</p>
        <p><a href="/recaptcha-v2-checkbox.php">⟳ Try again</a></p>
        <?php
    endif;
else:
    // Add the g-recaptcha tag to the form you want to include the reCAPTCHA element
    ?>
    <p>Complete the reCAPTCHA then submit the form.</p>
    <form action="/recaptcha-v2-checkbox.php" method="post">
        <fieldset>
            <legend>An example form</legend>
            <label class="form-field">Example input A: <input type="text" name="ex-a" value="foo"></label>
            <label class="form-field">Example input B: <input type="text" name="ex-b" value="bar"></label>
            <!-- Default behaviour looks for the g-recaptcha class with a data-sitekey attribute -->
            <div class="g-recaptcha form-field" data-sitekey="<?php echo $siteKey; ?>"></div>
            <!-- Submitting before the widget loads will result in a missing-input-response error so you need to verify server side -->
            <button class="form-field" type="submit">Submit ↦</button>
        </fieldset>
    </form>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>"></script>
    <?php
endif;?>
</main>

<!-- Google Analytics - just ignore this -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123057962-1"></script>
<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-123057962-1');</script>
