<?php


class ArticleTest extends \PHPUnit\Framework\TestCase
{

    // Test if title is required
    // Test if content is required
    // Tests if title minimum length is less or equal to 25 char
    // Tests if content minimum length is less or equal to 50 chars
    // Tests if all goes well

    public function testStoreArticleShouldThrowAnErrorIfTitleWasMissing()
    {
        $articleController = new \App\Controllers\ArticleController();
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->request->set('content', bin2hex(random_bytes(60)));

        $response = $articleController->storeArticle($request);
        $this->assertJsonStringEqualsJsonString(json_encode(['title'=>'This field is missing.']), $response->getContent());
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testStoreArticleShouldThrowAnErrorIfContentWasMissing()
    {
        $articleController = new \App\Controllers\ArticleController();
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->request->set('title', bin2hex(random_bytes(60)));

        $response = $articleController->storeArticle($request);
        $this->assertJsonStringEqualsJsonString(json_encode(['content'=>'This field is missing.']), $response->getContent());
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testStoreArticleShouldThrowAnErrorIfContentLengthIsLessThanExpectation()
    {
        $articleController = new \App\Controllers\ArticleController();
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->request->set('title', bin2hex(random_bytes(60)));
        $request->request->set('content', bin2hex(random_bytes(10)));

        $response = $articleController->storeArticle($request);
        $this->assertJsonStringEqualsJsonString(json_encode(['content'=>'This value is too short. It should have 50 characters or more.']), $response->getContent());
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testStoreArticleShouldThrowAnErrorIfTitleLengthIsLessThanExpectation()
    {
        $articleController = new \App\Controllers\ArticleController();
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->request->set('title', bin2hex(random_bytes(5)));
        $request->request->set('content', bin2hex(random_bytes(50)));

        $response = $articleController->storeArticle($request);
        $this->assertJsonStringEqualsJsonString(json_encode(['title'=>'This value is too short. It should have 25 characters or more.']), $response->getContent());
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testStoreArticleShouldReturnSuccessIfAllGoesWell()
    {
        $articleController = new \App\Controllers\ArticleController();
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->request->set('title', bin2hex(random_bytes(50)));
        $request->request->set('content', bin2hex(random_bytes(50)));

        $response = $articleController->storeArticle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

}