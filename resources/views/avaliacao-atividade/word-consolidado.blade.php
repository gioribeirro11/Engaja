<!DOCTYPE html>
<html lang="pt-BR" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">
<head>
    <meta charset="UTF-8">
    <title>Relatórios do Momento — {{ $atividade->descricao ?? 'Momento' }}</title>
    <!--[if gte mso 9]><xml><w:WordDocument><w:View>Print</w:View><w:Zoom>100</w:Zoom></w:WordDocument></xml><![endif]-->
    <style>
        @page { size: A4; margin: 2cm; }
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; color: #1f2937; }
        h1 { font-size: 20pt; color: #963d79; margin: 0 0 4pt 0; }
        h2 { font-size: 14pt; color: #111827; border-left: 6pt solid #963d79; padding-left: 8pt; margin: 18pt 0 8pt 0; }
        .sub { color: #6b7280; font-size: 10pt; margin: 0 0 12pt 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12pt; }
        th, td { border: 1px solid #d1d5db; padding: 6pt 8pt; vertical-align: top; text-align: left; }
        th { background: #963d79; color: #ffffff; }
        td.num { text-align: right; font-weight: bold; color: #963d79; width: 80pt; }
        .question { font-weight: bold; margin: 10pt 0 4pt 0; }
        .answer { border: 1px solid #e5e7eb; border-left: 3pt solid #963d79; background: #f8fafc; padding: 6pt 8pt; margin-bottom: 6pt; }
        .meta { color: #6b7280; font-size: 9pt; margin-bottom: 3pt; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
@php
    $evento = $atividade->evento;
@endphp

<h1>Relatórios do Momento</h1>
<p class="sub">
    Documento institucional consolidado — gerado em {{ now()->format('d/m/Y H:i') }} | Total: {{ $relatorios->count() }} relatório(s)
</p>

<h2>Dados do Momento</h2>
<table>
    <tr>
        <th style="width: 20%;">Ação pedagógica</th>
        <td>{{ $evento->nome ?? '—' }}</td>
        <th style="width: 15%;">Momento</th>
        <td>{{ $atividade->descricao ?? '—' }}</td>
    </tr>
    <tr>
        <th>Data</th>
        <td>{{ $atividade->dia ? \Carbon\Carbon::parse($atividade->dia)->format('d/m/Y') : '—' }}</td>
        <th>Horário</th>
        <td>
            {{ $atividade->hora_inicio ? \Carbon\Carbon::parse($atividade->hora_inicio)->format('H:i') : '?' }} -
            {{ $atividade->hora_fim ? \Carbon\Carbon::parse($atividade->hora_fim)->format('H:i') : '?' }}
        </td>
    </tr>
</table>

<h2>Quadro Resumo de Público</h2>
<table>
    <tr><td>Quantidade prevista de participantes</td><td class="num">{{ $resumoPublico['prevista'] ?? 0 }}</td></tr>
    <tr><td>Quantidade de inscritos</td><td class="num">{{ $resumoPublico['inscritos'] ?? 0 }}</td></tr>
    <tr><td>Quantidade de presentes na ação</td><td class="num">{{ $resumoPublico['presentes'] ?? 0 }}</td></tr>
    <tr><td>Participantes ligados aos movimentos sociais</td><td class="num">{{ $resumoPublico['movimentos'] ?? 0 }}</td></tr>
    <tr><td>Participantes com vínculo com a prefeitura</td><td class="num">{{ $resumoPublico['prefeitura'] ?? 0 }}</td></tr>
    <tr><td>Participantes com vínculo não informado</td><td class="num">{{ $resumoPublico['sem_vinculo'] ?? 0 }}</td></tr>
</table>

<h2>Perguntas e Respostas Consolidadas</h2>
<p class="sub">Cada pergunta abaixo reúne todas as respostas enviadas para este mesmo momento.</p>

@foreach($respostasPorPergunta as $itemPergunta)
    <div class="question">{{ $itemPergunta['pergunta'] }}</div>

    @if($itemPergunta['respostas']->isEmpty())
        <div class="answer muted">Nenhuma resposta registrada.</div>
    @else
        @foreach($itemPergunta['respostas'] as $resposta)
            <div class="answer">
                <div class="meta">
                    <strong>Responsável:</strong> {{ $resposta['responsavel_nome'] }}
                    @if(!empty($resposta['atualizado_em']))
                        | <strong>Enviado em:</strong> {{ $resposta['atualizado_em']->format('d/m/Y') }}
                    @endif
                </div>
                <div>{!! nl2br(e($resposta['resposta'])) !!}</div>
            </div>
        @endforeach
    @endif
@endforeach
</body>
</html>
