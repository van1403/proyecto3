<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@inventario.com',
            'dni' => '12345678',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Crear usuario cliente de ejemplo
        User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'cliente@ejemplo.com',
            'dni' => '87654321',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // Crear categorías
        $categories = [
            ['name' => 'Electrónicos', 'description' => 'Productos electrónicos y tecnología'],
            ['name' => 'Ropa', 'description' => 'Ropa y accesorios de moda'],
            ['name' => 'Hogar', 'description' => 'Artículos para el hogar'],
            ['name' => 'Deportes', 'description' => 'Equipos y ropa deportiva'],
            ['name' => 'Libros', 'description' => 'Libros y material educativo'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Crear proveedores
        $suppliers = [
            [
                'name' => 'Tech Supplies SA',
                'contact_email' => 'contacto@techsupplies.com',
                'phone' => '+1234567890',
                'address' => 'Av. Tecnología 123, Ciudad'
            ],
            [
                'name' => 'Moda Express',
                'contact_email' => 'ventas@modaexpress.com', 
                'phone' => '+0987654321',
                'address' => 'Calle Moda 456, Ciudad'
            ],
            [
                'name' => 'Hogar Total',
                'contact_email' => 'info@hogartotal.com',
                'phone' => '+1122334455',
                'address' => 'Av. Hogar 789, Ciudad'
            ],
            [
                'name' => 'Deportes Pro',
                'contact_email' => 'ventas@deportespro.com',
                'phone' => '+5566778899',
                'address' => 'Calle Deportes 321, Ciudad'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Crear productos de ejemplo
        $products = [
            [
                'name' => 'Smartphone XYZ',
                'description' => 'Teléfono inteligente de última generación con cámara de 48MP',
                'price' => 599.99,
                'stock' => 50,
                'category_id' => 1,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Laptop Gaming',
                'description' => 'Laptop para gaming de alto rendimiento con RTX 3060',
                'price' => 1299.99,
                'stock' => 25,
                'category_id' => 1,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Camiseta Deportiva',
                'description' => 'Camiseta transpirable para deportes, material dry-fit',
                'price' => 29.99,
                'stock' => 100,
                'category_id' => 2,
                'supplier_id' => 2,
            ],
            [
                'name' => 'Sartén Antiadherente',
                'description' => 'Sartén de cocina antiadherente premium, 28cm de diámetro',
                'price' => 49.99,
                'stock' => 75,
                'category_id' => 3,
                'supplier_id' => 3,
            ],
            [
                'name' => 'Balón de Fútbol',
                'description' => 'Balón oficial tamaño 5 para partidos profesionales',
                'price' => 39.99,
                'stock' => 60,
                'category_id' => 4,
                'supplier_id' => 4,
            ],
            [
                'name' => 'Auriculares Inalámbricos',
                'description' => 'Auriculares Bluetooth con cancelación de ruido',
                'price' => 89.99,
                'stock' => 40,
                'category_id' => 1,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Jeans Clásicos',
                'description' => 'Jeans de corte clásico, color azul oscuro',
                'price' => 59.99,
                'stock' => 80,
                'category_id' => 2,
                'supplier_id' => 2,
            ],
            [
                'name' => 'Juego de Sábanas',
                'description' => 'Juego de sábanas de algodón egipcio, tamaño queen',
                'price' => 79.99,
                'stock' => 30,
                'category_id' => 3,
                'supplier_id' => 3,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}