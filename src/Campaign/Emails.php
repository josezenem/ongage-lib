<?php
/**
 * Emails class
 * @author Abilio Henrique <abilio.henrique@rfg.com.au>
 * @copyright Retail Food Group Ltd
 *
 */
namespace RfgOngage\Campaign;

/**
 * Emails class
 * Implementation of the Ongage /emails endpoint
 *
 * @link http://apidocs.ongage.net/class-Controller_API_Emails.html
 */
class Emails
{

    /**
     *
     * @var string $base_endpoint Variable corresponding to the /emails Ongage Endpoint
     */
    public $base_endpoint = '/emails';

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
     * Returns paginated emails results for a list_id (defaults to default list)
     *
     * @param integer $list_id
     *            List Id to look up emails in
     * @param string $type
     *            Email Object type - "email_message", "template" or "folder". Defaults to "email_message".
     * @param string $name
     *            Email name
     * @param integer $parent_id
     *            Id of folder in which template is located
     * @param string $subject
     *            The subject of the email
     * @param integer $modified_from
     *            Unix Timestamp to return email results from
     * @param integer $modified_to
     *            Unix Timestamp to return email results to
     * @param integer $created_by
     *            User Id to search from
     * @param boolean $favorite
     *            Return emails marked as favourite
     * @param integer $page
     *            Set current page number - Default: 1
     * @param integer $page_size
     *            Set size of pages to return results from - Default: 50
     */
    public function get($list_id = null, $type = null, $name = null, $parent_id = null, $subject = null, $modified_from = null, $modified_to = null, $created_by = null, $favorite = null, $page = 1, $page_size = 50)
    {
        $this->method = '';
        $this->request_type = 'GET';
        $this->body = '';
        $this->query = array();
        if (! empty($list_id)) {
            $this->query['list_id'] = $list_id;
        }
        if (! empty($name)) {
            $this->query['name'] = $name;
        }
        if (! empty($type)) {
            $this->query['type'] = $type;
        }
        if (! empty($parent_id)) {
            $this->query['parent_id'] = $parent_id;
        }
        if (! empty($subject)) {
            $this->query['subject'] = $subject;
        }
        if (! empty($modified_from)) {
            $this->query['modified_from'] = $modified_from;
        }
        if (! empty($modified_to)) {
            $this->query['modified_to'] = $modified_to;
        }
        if (! empty($created_by)) {
            $this->query['created_by'] = $created_by;
        }
        if (! empty($favorite)) {
            $this->query['favorite'] = (int) $favorite;
        }
        if (! empty($page)) {
            $this->query['page'] = (int) $page;
        }
        if (! empty($page_size)) {
            $this->query['page_size'] = (int) $page_size;
        }
        return $this;
    }

    /**
     * Function getById()
     * Gets a single email
     *
     * @param integer $email_id
     *            Id for email
     * @param integer $list_id
     *            List Id to load email from (Defaults to default list)
     */
    public function getById($email_id, $list_id = null)
    {
        $this->method = '/' . (int) $email_id;
        $this->request_type = 'GET';
        $this->body = '';
        $this->query = array();
        if (! empty($list_id)) {
            $this->query['list_id'] = (int) $list_id;
        }
        return $this;
    }

    /**
     * Function getEmailLinks()
     * Gets links for a single email
     *
     * @param string $email_id
     *            Id for email
     */
    public function getEmailLinks($email_id)
    {
        $this->method = '/' . (int) $email_id . '/links';
        $this->request_type = 'GET';
        $this->body = '';
        $this->query = array();
        return $this;
    }

    /**
     * Function post()
     * Creates a new email
     *
     * @param string $name
     *            Email name (Required)
     * @param integer $list_id
     *            List Id to look up emails in
     * @param string $type
     *            Email Type - "email_message", "template" or "folder" (Required)
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
     */
    public function post($name, $list_id = null, $type = 'email_message', $parent_id = null, $description, $subject, $content_html, $content_text, $favorite = null, $no_wysiwyg = false, $language_iso = 'en')
    {
        $this->method = '';
        $this->request_type = 'POST';
        $this->body = '';
        $this->query = array();
        
        $parameters = array(
            'type' => $type,
            'list_id' => $list_id,
            'parent_id' => $parent_id,
            'name' => $name,
            'description' => $description,
            'subject' => $description,
            'content_html' => $content_html,
            'content_text' => $content_text,
            'favorite' => $favorite,
            'no_wysiwyg' => $no_wysiwyg,
            'language_iso' => $language_iso
        );
        
        $this->body = json_encode($parameters);
        return $this;
    }

    /**
     * Function put()
     * Updates an email
     *
     * @param integer $email_id
     *            Email Id To Edit
     * @param string $name
     *            Email name (Required)
     * @param integer $list_id
     *            List Id to look up emails in
     * @param string $type
     *            Email Type - "email_message", "template" or "folder" (Required)
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
    public function put($email_id, $name, $type = 'email_message', $parent_id = null, $description, $subject, $content_html, $content_text, $favorite = null, $language_iso = 'en', $addresses)
    {
        $this->method = '/' . (int) $email_id;
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        
        $parameters = array(
            'type' => $type,
            'parent_id' => $parent_id,
            'name' => $name,
            'description' => $description,
            'subject' => $description,
            'content_html' => $content_html,
            'content_text' => $content_text,
            'favorite' => $favorite,
            'language_iso' => $language_iso,
            'addresses' => $addresses
        );
        
        $this->body = json_encode($parameters);
        return $this;
    }

    /**
     * Function favorite()
     * Sets an email as favorite
     *
     * @param integer $email_id
     *            Email Id To Edit
     */
    public function favorite($email_id)
    {
        $this->method = '/' . (int) $email_id . '/favorite';
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        return $this;
    }

    /**
     * Function delete()
     * Deletes email for supplied id
     *
     * @param integer $email_id
     *            Email ID to delete
     */
    public function delete($email_id)
    {
        $this->method = '/' . (int) $email_id;
        $this->request_type = 'DELETE';
        $this->body = '';
        $this->query = array();
        return $this;
    }

    /**
     * Function move()
     * Moves or renames an email/template in library
     *
     * @param integer $email_id
     *            Email Id To Edit
     * @param integer $parent_id
     *            Folder in which this item resides - 0 for root (Required)
     * @param string $name
     *            Name of email
     */
    public function move($email_id, $parent_id, $name)
    {
        $this->method = '/' . (int) $email_id . '/favorite';
        $this->request_type = 'PUT';
        $this->body = '';
        $this->query = array();
        $parameters = array(
            'parent_id' => $parent_id,
            'name' => $name
        );
        $this->body = json_encode($parameters);
        return $this;
    }
}
?>