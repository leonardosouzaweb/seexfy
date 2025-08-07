<?php
require_once '../../../inc/db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Acesso não autorizado.');
}

$user_id = $_SESSION['user_id'];
$errors = [];

// Identifica se os dados enviados são do perfil principal ou da(o) parceira(o)
$isPartnerUpdate = isset($_POST['partner_idade']);

// ====================
// 📌 Atualiza parceiro(a) se for esse o caso
// ====================
if ($isPartnerUpdate) {
    $partnerFields = [
        'idade', 'orientacao', 'signo', 'altura', 'fuma', 'bebe', 'experiencia'
    ];
    $partnerData = [];
    foreach ($partnerFields as $field) {
        $partnerData[$field] = trim($_POST['partner_' . $field] ?? '');
    }

    // Validações da parceira(o)
    if (!is_numeric($partnerData['idade']) || $partnerData['idade'] < 18 || $partnerData['idade'] > 120) {
        $errors[] = 'Idade da parceira(o) inválida.';
    }
    foreach (['orientacao', 'signo', 'altura', 'fuma', 'bebe', 'experiencia'] as $f) {
        if (empty($partnerData[$f])) {
            $errors[] = "Informe {$f} da parceira(o).";
        }
    }

    if (!$errors) {
        try {
            // Verifica se já existe
            $stmt = $pdo->prepare("SELECT id FROM partner_profiles WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $exists = $stmt->fetch();

            if ($exists) {
                $stmt = $pdo->prepare("
                    UPDATE partner_profiles SET
                        idade = :idade,
                        orientacao = :orientacao,
                        signo = :signo,
                        altura = :altura,
                        fuma = :fuma,
                        bebe = :bebe,
                        experiencia = :experiencia
                    WHERE user_id = :user_id
                ");
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO partner_profiles (
                        user_id, idade, orientacao, signo, altura, fuma, bebe, experiencia
                    ) VALUES (
                        :user_id, :idade, :orientacao, :signo, :altura, :fuma, :bebe, :experiencia
                    )
                ");
            }

            $stmt->execute([
                ':user_id'     => $user_id,
                ':idade'       => $partnerData['idade'],
                ':orientacao'  => $partnerData['orientacao'],
                ':signo'       => $partnerData['signo'],
                ':altura'      => $partnerData['altura'],
                ':fuma'        => $partnerData['fuma'],
                ':bebe'        => $partnerData['bebe'],
                ':experiencia' => $partnerData['experiencia']
            ]);
        } catch (PDOException $e) {
            $errors[] = 'Erro ao salvar dados da(o) parceira(o): ' . $e->getMessage();
        }
    }
}
// ====================
// 📌 Atualiza perfil principal se enviado
// ====================
else {
    $idade       = trim($_POST['idade'] ?? '');
    $orientacao  = trim($_POST['orientacao'] ?? '');
    $signo       = trim($_POST['signo'] ?? '');
    $altura      = trim($_POST['altura'] ?? '');
    $fuma        = trim($_POST['fuma'] ?? '');
    $bebe        = trim($_POST['bebe'] ?? '');
    $experiencia = trim($_POST['experiencia'] ?? '');

    if (!is_numeric($idade) || $idade < 18 || $idade > 120) {
        $errors[] = 'Idade inválida.';
    }
    if (empty($orientacao))  $errors[] = 'Informe a orientação sexual.';
    if (empty($signo))       $errors[] = 'Informe o signo.';
    if (empty($altura))      $errors[] = 'Informe a altura.';
    if (empty($fuma))        $errors[] = 'Informe se fuma.';
    if (empty($bebe))        $errors[] = 'Informe se bebe.';
    if (empty($experiencia)) $errors[] = 'Informe sua experiência no meio liberal.';

    // Tratamento do campo interests para manter valor anterior se não enviado ou vazio
    if (isset($_POST['interests']) && !empty($_POST['interests'])) {
        $interestsJson = json_encode($_POST['interests']);
    } else {
        // Busca o valor atual do banco para manter
        $stmt = $pdo->prepare("SELECT interests FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $interestsJson = $stmt->fetchColumn() ?: '[]';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare("
                UPDATE users SET
                    idade = :idade,
                    orientacao = :orientacao,
                    signo = :signo,
                    altura = :altura,
                    fuma = :fuma,
                    bebe = :bebe,
                    experiencia = :experiencia,
                    interests = :interests
                WHERE id = :id
            ");
            $stmt->execute([
                ':idade'       => $idade,
                ':orientacao'  => $orientacao,
                ':signo'       => $signo,
                ':altura'      => $altura,
                ':fuma'        => $fuma,
                ':bebe'        => $bebe,
                ':experiencia' => $experiencia,
                ':interests'   => $interestsJson,
                ':id'          => $user_id
            ]);
        } catch (PDOException $e) {
            $errors[] = 'Erro ao atualizar perfil: ' . $e->getMessage();
        }
    }
}

// ====================
// 🔄 Redirecionamento
// ====================
$_SESSION['toast'] = [
    'type' => $errors ? 'error' : 'success',
    'message' => $errors ? implode('<br>', $errors) : 'Informações atualizadas com sucesso!'
];

// Busca o username para redirecionar à URL amigável
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$username = $stmt->fetchColumn();

header("Location: ../../../profile/$username");
exit;
