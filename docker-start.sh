#!/bin/bash

# Script para iniciar o ambiente Docker
echo "🚀 Iniciando ambiente Docker do Restaurante MVC..."

# Verificar se Docker está rodando
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker não está rodando. Por favor, inicie o Docker primeiro."
    exit 1
fi

# Parar containers existentes
echo "🛑 Parando containers existentes..."
docker-compose down

# Construir e iniciar containers
echo "🔨 Construindo e iniciando containers..."
docker-compose up --build -d

# Aguardar MySQL inicializar
echo "⏳ Aguardando MySQL inicializar..."
sleep 10

# Verificar status dos containers
echo "📊 Status dos containers:"
docker-compose ps

echo ""
echo "✅ Ambiente Docker iniciado com sucesso!"
echo ""
echo "🌐 Aplicação: http://localhost:8080"
echo "🗄️  phpMyAdmin: http://localhost:8081"
echo ""
echo "📝 Credenciais do banco:"
echo "   Host: localhost:3306"
echo "   Database: restaurante-mvc"
echo "   Usuário: restaurante"
echo "   Senha: restaurante123"
echo ""
echo "👤 Usuário administrador padrão:"
echo "   Usuário: admin"
echo "   Senha: password"
echo ""
echo "Para parar o ambiente: ./docker-stop.sh"
