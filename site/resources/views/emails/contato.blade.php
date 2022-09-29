@component('mail::message')
# Novo Contato

**Nome:** {{ $data['nome']  }}

**E-mail:** {{ $data['email'] }}

**Telefone:** {{ $data['telefone'] }}

**Cidade:** {{ $data['cidade'] }}

**Mensagem:** {!! $data['mensagem'] !!}

@endcomponent
