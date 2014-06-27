<?php
/**
 * Mailings class
 * @author Abilio Henrique <abilio.henrique@rfg.com.au>
 * @copyright Retail Food Group Ltd
 *
 */
namespace RfgOngage\Campaign;

/**
 * Mailings class
 * Implementation of the Ongage /mailings endpoint
 *
 * @link http://apidocs.ongage.net/class-Controller_API_Mailings.html
 */
class Mailings
{

    /**
     *
     * @var string $base_endpoint Variable corresponding to the /emails Ongage Endpoint
     */
    public $base_endpoint = '/mailings';

    /**
     *
     * @var string $contentType Content-Type for the API requests
     */
    public $contentType = 'application/json';

    /**
     *
     * @var string $method Corresponding method in the Ongage API
     */
    public $method;

    /**
     *
     * @var string $request_type HTTP Request Type for the API call (e.g. GET/POST/PUT/DELETE/PATCH etc).
     */
    public $request_type;

    /**
     *
     * @var array $query Array of HTTP Query variables for the API call
     */
    public $query = array();

    /**
     *
     * @var array $body The body of the HTTP request
     */
    public $body = '';

    /**
     * Function get()
     * Gets a list of mailing campaigns
     *
     * @param string $mailing_id
     *            Mailing Id
     * @param string $list_id
     *            List Id for segments, leave empty for default list
     */
    public function get($mailing_id = null, $list_id = null)
    {
        if (! empty($mailing_id)) {
            $this->method = '/' . (int) $mailing_id;
        } else {
            $this->method = '';
        }
        $this->request_type = 'GET';
        $this->body = '';
        $this->query = array();
        if (! empty($list_id)) {
            $this->query['list_id'] = (int) $list_id;
        }
        return $this;
    }

    /**
     * Function post()
     * Returns paginated emails results for a list_id (defaults to default list)
     *
     * @param string $name
     *            Mailing Campaign internal name (Required)
     * @param integer $list_id
     *            List Id to attach this mailing to (defaults to default list)
     * @param string $type
     *            Mailing type - "campaign" or "split".
     * @param string $split_type
     *            Split campaign type - "email", "segment", "esp", "subject".
     * @param boolean $use_default_esp
     *            Use only default ESP (Email Service Provider) from distribution
     * @param string $description
     *            Campaign description for internal use (Required)
     * @param boolean $favorite
     *            Return emails marked as favourite
     * @param integer $schedule_date
     *            Delivery date & time as Unix Timestamp
     * @param integer[] $email_message
     *            An array of integers containing the email ids to be sent with this campaign
     * @param integer[] $segments
     *            An array of integers containing the segments ids this campaign will be sent to
     * @param integer[] $segments_excluded
     *            An array of segment ids to exclude from this campaign
     * @param string[] $subjects
     *            An array of strings containing subjects to test the campaign. Required for "subject" split_type.
     * @param boolean $is_test
     *            Mark this campaign as a test campaign
     * @param string[] $recipients
     *            Array of email addresses for test campaigns.
     * @param array[] $distribution
     *            A multi dimensional array containing the ESP delivery configuration.
     *            Has the ability to deliver percentages of different emails to different ESPs.
     *            Examples:
     *            
     *            Regular campaign request:
     *            
     *            $distribution = [
     *            [
     *            "domain" => "default",
     *            "esp_id" => 5
     *            ],
     *            [
     *            "domain" => "gmail.com",
     *            "esp_id" => 6
     *            ],
     *            [
     *            "domain" => "hotmail.com",
     *            "esps" => [
     *            "5" => 20, // 20% of hotmail.com emails will be sent via ESP Id 5
     *            "6" => 80 // 80% of hotmail.com emails will be sent via ESP Id 6
     *            ]
     *            ];
     *            
     *            Split campaign request:
     *            
     *            $distribution = [
     *            [
     *            "isp_id" => 0
     *            "domain" => "default",
     *            "esp_id" => 5
     *            ],
     *            [
     *            "isp_id" => 1
     *            "domain" => "gmail.com",
     *            "esp_id" => 6
     *            ],
     *            [
     *            "isp_id" => 1
     *            "domain" => "hotmail.com",
     *            "esps" => [
     *            "5" => 20, // 20% of hotmail.com emails will be sent via ESP Id 5
     *            "6" => 80 // 80% of hotmail.com emails will be sent via ESP Id 6
     *            ]
     *            ];
     *            
     */
    public function post($name, $list_id = null, $type = null, $split_type = null, $use_default_esp = true, $description, $favorite = null, $schedule_date = null, $email_message, $segments, $segments_excluded = array(), $subjects = null, $is_test = false, $recipients = null, $distribution)
    {
        $this->method = '';
        $this->request_type = 'POST';
        $this->body = '';
        $this->query = array();
        $parameters = array(
            'name' => $name,
            'list_id' => $list_id,
            'type' => $type,
            'split_type' => $split_type,
            'use_default_esp' => $use_default_esp,
            'description' => $description,
            'favorite' => $favorite,
            // 'schedule_date' => $schedule_date,
            'email_message' => $email_message,
            'segments' => $segments,
            'segments_excluded' => $segments_excluded,
            'subjects' => $subjects,
            'is_test' => $is_test,
            'recipients' => $recipients,
            'distribution' => $distribution
        );
        
        $this->body = json_encode($parameters);
        return $this;
    }

    /**
     * Function transactional_campaign()
     * Creates a new transactional mailing campaign
     *
     * @param string $name
     *            Name for describing the transactional campaign
     * @param string $description
     *            Description for the transactional campaign
     * @param string $list_id
     *            List Id to attach transactional campaign to
     * @param string $favourite
     *            Mark transactional campaign as favourite
     */
    public function transactional_campaign($name, $description, $list_id = null, $favourite = false)
    {
        $this->method = '/' . (int) $email_id . '/links';
        $this->request_type = 'POST';
        $this->body = '';
        $this->query = array();
        
        $parameters = array();
        if (! empty($name)) {
            $parameters['name'] = $name;
        }
        if (! empty($description)) {
            $parameters['description'] = $description;
        }
        if (! empty($list_id)) {
            $parameters['list_id'] = $list_id;
        }
        if (! empty($favorite)) {
            $parameters['favorite'] = (int) $favorite;
        }
        $this->body = json_encode($parameters);
        return $this;
    }

    /**
     * Function put()
     * Updates an existing mailing campaign
     *
     * @param integer $mailing_id
     *            Email Id To Edit
     * @param string $name
     *            Email name (Required)
     * @param integer $list_id
     *            List Id to look up emails in
     * @param string $type
     *            Campaign Type - "campaign", "split"
     * @param integer $parent_id
     *            Id of folder in which template is located
     * @param string $description
     *            Email description (Required)
     * @param string $subject
     *            The subject of the email (Required)
     * @param string $content_html
     *            The HTML portion of the email content (Required)
     * @param string $content_text
     *            The Plain-text portion of the email content (Required)
     * @param boolean $favorite
     *            Whether to mark the email as favourite
     * @param boolean $no_wysiwyg
     *            Enable/Disable WYSIWYG Editor for email
     * @param string $language_iso
     *            The 2-letter language ISO code for the email ({@link http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes Wikipedia Language ISO code list})
     * @param array $addresses
     *            An array containing information about the send/from and reply-to addresses for this email
     */
    public function put($mailing_id, $name = null, $description = null, $type = null, $split_type = null, $use_default_esp = null, $favorite = null, $schedule_date = null, $subjects = null, $segments = null, $distribution = null)
    {
        $this->method = '/' . (int) $mailing_id;
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        
        $parameters = array();
        
        if (! empty($name)) {
            $parameters['name'] = $name;
        }
        if (! empty($description)) {
            $parameters['description'] = $description;
        }
        if (! empty($type)) {
            $parameters['type'] = $type;
        }
        if (! empty($split_type)) {
            $parameters['split_type'] = $split_type;
        }
        if (! empty($use_default_esp)) {
            $parameters['use_default_esp'] = $use_default_esp;
        }
        if (! empty($favorite)) {
            $parameters['favorite'] = $favorite;
        }
        if (! empty($schedule_date)) {
            $parameters['schedule_date'] = $schedule_date;
        }
        if (! empty($subjects)) {
            $parameters['subjects'] = $subjects;
        }
        if (! empty($segments)) {
            $parameters['segments'] = $segments;
        }
        if (! empty($distribution)) {
            $parameters['distribution'] = $distribution;
        }
        $this->body = json_encode($parameters);
        return $this;
    }

    /**
     * Function abort()
     * Toggle campaign status On Hold/Stopped/In Progress
     *
     * @param integer $mailing_id
     *            Mailing campaign id to toggle
     */
    public function abort($mailing_id)
    {
        $this->method = '/' . (int) $mailing_id . '/abort';
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        return $this;
    }

    /**
     * Function cancel()
     * Cancel email for supplied id
     *
     * @param integer $mailing_id
     *            mailing campaign id to cancel
     */
    public function cancel($mailing_id)
    {
        $this->method = '/' . (int) $mailing_id . '/cancel';
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        return $this;
    }

    /**
     * Function delete()
     * Deletes email for supplied id
     *
     * @param integer $mailing_id
     *            mailing campaign id to delete
     */
    public function delete($mailing_id)
    {
        $this->method = '/' . (int) $mailing_id . '';
        $this->request_type = 'DELETE';
        $this->body = '';
        $this->query = array();
        return $this;
    }
}
?>