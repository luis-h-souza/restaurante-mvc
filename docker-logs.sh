#!/bin/bash

# Script para visualizar logs do Docker
echo "📋 Visualizando logs do ambiente Docker..."

# Verificar se containers estão rodando
if ! docker-compose ps | grep -q "Up"; then
    echo "❌ Nenhum container está rodando. Execute ./docker-start.sh primeiro."
    exit 1
fi

echo "Escolha uma opção:"
echo "1) Logs da aplicação web"
echo "2) Logs do MySQL"
echo "3) Logs do phpMyAdmin"
echo "4) Todos os logs"
echo "5) Logs em tempo real (follow)"

read -p "Digite sua opção (1-5): " option

case $option in
    1)
        echo "📱 Logs da aplicação web:"
        docker-compose logs web
        ;;
    2)
        echo "🗄️ Logs do MySQL:"
        docker-compose logs mysql
        ;;
    3)
        echo "🔧 Logs do phpMyAdmin:"
        docker-compose logs phpmyadmin
        ;;
    4)
        echo "📋 Todos os logs:"
        docker-compose logs
        ;;
    5)
        echo "📱 Logs em tempo real (Ctrl+C para sair):"
        docker-compose logs -f
        ;;
    *)
        echo "❌ Opção inválida!"
        exit 1
        ;;
esac
