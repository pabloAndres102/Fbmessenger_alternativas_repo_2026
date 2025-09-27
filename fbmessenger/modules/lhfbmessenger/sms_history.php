<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/sms_history.tpl.php');

// -----------------------------
// FILTROS (GET)
// -----------------------------
$filter = [];

// phone -> "contains"
$searchPhone = isset($_GET['phone']) ? trim($_GET['phone']) : '';
if ($searchPhone !== '') {
    $filter['filterlike']['phone'] = $searchPhone;
    $tpl->set('phone', $searchPhone);
}

// campaign -> exact match (opcional)
$searchCampaign = isset($_GET['campaign']) ? trim($_GET['campaign']) : '';
if ($searchCampaign !== '') {
    $filter['filter']['campaign'] = $searchCampaign;
    $tpl->set('campaign', $searchCampaign);
}

// status (opcional)
$searchStatus = isset($_GET['status']) ? trim($_GET['status']) : '';
if ($searchStatus !== '') {
    $filter['filter']['status'] = $searchStatus;
    $tpl->set('status', $searchStatus);
}

// -----------------------------
// PAGINACIÓN MANUAL (funcional)
// -----------------------------
$itemsPerPage = 10;

// página actual desde GET ?page=2
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;

// total de ítems con filtros aplicados
$totalItems = erLhcoreClassModelSms::getCount($filter);

// calcular total páginas
$totalPages = $totalItems > 0 ? (int)ceil($totalItems / $itemsPerPage) : 1;
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $itemsPerPage;

// traer mensajes con limit/offset y orden descendente
$listFilter = $filter;
$listFilter['limit']  = $itemsPerPage;
$listFilter['offset'] = $offset;
$listFilter['sort']   = 'id DESC';

$messages = erLhcoreClassModelSms::getList($listFilter);

// -----------------------------
// CONSTRUIR HTML DE PAGINACIÓN
// -----------------------------
$baseUrl = erLhcoreClassDesign::baseurl('fbmessenger/sms_history'); // ajusta si tu ruta es otra
// mantener otros parámetros GET (filtros) en los links
$queryParams = $_GET;
function buildPageUrl($baseUrl, $queryParams, $pageNum) {
    $qp = $queryParams;
    $qp['page'] = $pageNum;
    return $baseUrl . '?' . http_build_query($qp);
}

$paginationHtml = '';
if ($totalPages > 1) {
    $paginationHtml .= '<nav aria-label="Paginación SMS"><ul class="pagination" style="display:flex;gap:6px;list-style:none;padding:0;margin:12px 0;">';

    // Anterior
    if ($page > 1) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $page - 1)) . '">&laquo; Anterior</a></li>';
    } else {
        $paginationHtml .= '<li class="page-item disabled"><span class="page-link" style="opacity:.6">&laquo; Anterior</span></li>';
    }

    // Rango de páginas (ventana de 5)
    $start = max(1, $page - 2);
    $end = min($totalPages, $page + 2);

    if ($start > 1) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, 1)) . '">1</a></li>';
        if ($start > 2) {
            $paginationHtml .= '<li class="page-item disabled"><span class="page-link">…</span></li>';
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            $paginationHtml .= '<li class="page-item active"><span class="page-link" style="background:#007bff;color:#fff;border-radius:4px;padding:6px 10px;">' . $i . '</span></li>';
        } else {
            $paginationHtml .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $i)) . '">' . $i . '</a></li>';
        }
    }

    if ($end < $totalPages) {
        if ($end < $totalPages - 1) {
            $paginationHtml .= '<li class="page-item disabled"><span class="page-link">…</span></li>';
        }
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $totalPages)) . '">' . $totalPages . '</a></li>';
    }

    // Siguiente
    if ($page < $totalPages) {
        $paginationHtml .= '<li class="page-item"><a class="page-link" href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $page + 1)) . '">Siguiente &raquo;</a></li>';
    } else {
        $paginationHtml .= '<li class="page-item disabled"><span class="page-link" style="opacity:.6">Siguiente &raquo;</span></li>';
    }

    $paginationHtml .= '</ul></nav>';
}

// -----------------------------
// PASAR DATOS A LA VISTA
// -----------------------------
$tpl->set('messages', $messages);
$tpl->set('paginationHtml', $paginationHtml);
$tpl->set('totalItems', $totalItems);
$tpl->set('currentPage', $page);
$tpl->set('totalPages', $totalPages);
$tpl->set('itemsPerPage', $itemsPerPage);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','SMS')
    )
);
