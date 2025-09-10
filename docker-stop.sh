#!/bin/bash

# Script para parar o ambiente Docker
echo "🛑 Parando ambiente Docker do Restaurante MVC..."

# Parar containers
docker-compose down

echo "✅ Ambiente Docker parado com sucesso!"
echo ""
echo "Para remover completamente (incluindo volumes):"
echo "docker-compose down -v"
