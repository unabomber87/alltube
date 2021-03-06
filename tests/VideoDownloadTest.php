<?php
/**
 * VideoDownloadTest class
 *
 * PHP Version 5.3.10
 *
 * @category Youtube-dl
 * @package  Youtubedl
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU General Public License http://www.gnu.org/licenses/gpl.html
 * @link     http://rudloff.pro
 * */
namespace Alltube\Test;

use Alltube\VideoDownload;

/**
 * Unit tests for the VideoDownload class
 *
 * PHP Version 5.3.10
 *
 * @category Youtube-dl
 * @package  Youtubedl
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU General Public License http://www.gnu.org/licenses/gpl.html
 * @link     http://rudloff.pro
 * */
class VideoDownloadTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->download = new VideoDownload();
    }

    /**
     * Test listExtractors function
     *
     * @return void
     */
    public function testListExtractors()
    {
        $extractors = $this->download->listExtractors();
        $this->assertContains('youtube', $extractors);
    }

    /**
     * Test getURL function
     *
     * @param string $url    URL
     * @param string $format Format
     *
     * @return       void
     * @dataProvider urlProvider
     */
    public function testGetURL($url, $format, $filename, $domain)
    {
        $videoURL = $this->download->getURL($url, $format);
        $this->assertContains($domain, $videoURL);
    }

    /**
     * Test getURL function errors
     *
     * @param string $url URL
     *
     * @return            void
     * @expectedException Exception
     * @dataProvider      ErrorUrlProvider
     */
    public function testGetURLError($url)
    {
        $this->download->getURL($url);
    }

    /**
     * Provides URLs for tests
     *
     * @return array
     */
    public function urlProvider()
    {
        return array(
            array(
                'https://www.youtube.com/watch?v=M7IpKCZ47pU', null,
                "It's Not Me, It's You - Hearts Under Fire-M7IpKCZ47pU.mp4",
                'googlevideo.com'
            ),
            array(
                'https://www.youtube.com/watch?v=RJJ6FCAXvKg', 22,
                "'Heart Attack' - Demi Lovato ".
                "(Sam Tsui & Against The Current)-RJJ6FCAXvKg.mp4",
                'googlevideo.com'
            ),
            array(
                'https://vimeo.com/24195442', null,
                "Carving the Mountains-24195442.mp4",
                'vimeocdn.com'
            ),
        );
    }

    /**
     * Provides incorrect URLs for tests
     *
     * @return array
     */
    public function errorUrlProvider()
    {
        return array(
            array('http://example.com/video')
        );
    }

    /**
     * Test getJSON function
     *
     * @param string $url    URL
     * @param string $format Format
     *
     * @return       void
     * @dataProvider URLProvider
     */
    public function testGetJSON($url, $format)
    {
        $info = $this->download->getJSON($url, $format);
        $this->assertObjectHasAttribute('webpage_url', $info);
        $this->assertObjectHasAttribute('url', $info);
        $this->assertObjectHasAttribute('ext', $info);
        $this->assertObjectHasAttribute('title', $info);
        $this->assertObjectHasAttribute('formats', $info);
        $this->assertObjectHasAttribute('_filename', $info);
    }

    /**
     * Test getJSON function errors
     *
     * @param string $url URL
     *
     * @return            void
     * @expectedException Exception
     * @dataProvider      ErrorURLProvider
     */
    public function testGetJSONError($url)
    {
        $videoURL = $this->download->getJSON($url);
    }
}
