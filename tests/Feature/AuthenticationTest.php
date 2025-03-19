<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Test que l'accès aux pages protégées sans connexion redirige vers la page de connexion appropriée.
     */
    public function test_protected_pages_redirect_to_login()
    {
        $protectedUrls = [
            // URLs et leurs destinations de redirection attendues
            ['/sommaire', '/'],
            ['/gererFrais', '/'],
            ['/selectionMois', '/'],
            ['/listeVisiteurs', '/gestionnaire'],
            ['/ajoutVisiteur', '/gestionnaire'],
            ['/gestionnaireAccueil', '/gestionnaire'],
        ];

        foreach ($protectedUrls as [$url, $expectedRedirect]) {
            $response = $this->get($url);
            $response->assertRedirect($expectedRedirect);
        }
    }

    /**
     * Test que les tentatives d'accès non autorisé sont journalisées.
     */
    public function test_unauthorized_access_is_logged()
    {
        // Créer un handler de log temporaire pour les tests
        $testLogPath = storage_path('logs/test.log');
        if (file_exists($testLogPath)) {
            unlink($testLogPath);
        }
        
        // Configurer un canal de log temporaire
        config(['logging.channels.test' => [
            'driver' => 'single',
            'path' => $testLogPath,
            'level' => 'debug',
        ]]);
        
        // Utiliser ce canal pour le test
        config(['logging.channels.security' => config('logging.channels.test')]);
        
        // Tenter d'accéder à une page protégée
        $this->get('/sommaire');
        
        // Vérifier que le log contient notre message
        $this->assertFileExists($testLogPath);
        $logContent = file_get_contents($testLogPath);
        $this->assertStringContainsString('Tentative d\'accès non autorisé', $logContent);
        $this->assertStringContainsString('sommaire', $logContent);
    }

    /**
     * Test que le canal de journalisation de sécurité est correctement configuré
     */
    public function test_security_log_channel_exists()
    {
        $this->assertArrayHasKey('security', config('logging.channels'));
        $this->assertEquals('daily', config('logging.channels.security.driver'));
        $this->assertEquals(storage_path('logs/security.log'), config('logging.channels.security.path'));
    }
} 