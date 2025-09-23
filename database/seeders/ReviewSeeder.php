<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing reviews
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Review::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get products and users
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️  No products or users found. Please seed products and users first.');
            return;
        }

        $reviewCount = 0;

        // Sample review data
        $reviewTemplates = [
            // 5-star reviews
            [
                'rating' => 5,
                'titles' => [
                    'Amazing product!',
                    'Exceeded my expectations',
                    'Perfect quality',
                    'Highly recommend!',
                    'Outstanding value',
                    'Love it!',
                    'Fantastic purchase'
                ],
                'comments' => [
                    'This product is absolutely fantastic! The quality is top-notch and it arrived exactly as described. I would definitely buy from this store again.',
                    'I am thoroughly impressed with this purchase. The attention to detail is remarkable and the customer service was excellent.',
                    'Perfect fit and excellent quality. This exceeded all my expectations and I would highly recommend it to anyone.',
                    'Outstanding product! The craftsmanship is superb and the delivery was incredibly fast. Five stars all the way!',
                    'This is exactly what I was looking for. Great value for money and the quality is exceptional.',
                    'Absolutely love this product! It works perfectly and looks even better than in the photos.',
                    'Fantastic quality and great customer service. Will definitely be ordering more items from this store.'
                ]
            ],
            // 4-star reviews
            [
                'rating' => 4,
                'titles' => [
                    'Very good product',
                    'Good quality',
                    'Satisfied with purchase',
                    'Pretty good',
                    'Good value',
                    'Nice product',
                    'Recommended'
                ],
                'comments' => [
                    'Good quality product overall. There are minor areas for improvement but I am generally satisfied with my purchase.',
                    'Very pleased with this item. It meets most of my expectations and the price is reasonable.',
                    'Solid product with good build quality. Delivery was prompt and packaging was secure.',
                    'Pretty good product. It does what it promises and the quality is decent for the price point.',
                    'I like this product. It has some nice features and overall good value for money.',
                    'Good purchase. The product works well and looks nice. Would consider buying again.',
                    'Satisfied customer here. The product is good quality and arrived on time.'
                ]
            ],
            // 3-star reviews
            [
                'rating' => 3,
                'titles' => [
                    'Average product',
                    'It\'s okay',
                    'Mixed feelings',
                    'Decent but not great',
                    'Could be better',
                    'Fair quality',
                    'Acceptable'
                ],
                'comments' => [
                    'The product is okay but nothing special. It does the job but I expected a bit more for the price.',
                    'Average quality. It works as intended but there are definitely better options available.',
                    'Mixed feelings about this purchase. Some aspects are good while others could be improved.',
                    'Decent product but not exceptional. It meets basic requirements but lacks some features I was hoping for.',
                    'Fair quality for the price. It\'s not bad but it\'s not great either. Just average overall.',
                    'The product is acceptable but I think it could be better designed and manufactured.',
                    'It\'s an okay product. Does what it needs to do but doesn\'t stand out in any particular way.'
                ]
            ],
            // 2-star reviews
            [
                'rating' => 2,
                'titles' => [
                    'Disappointed',
                    'Not as expected',
                    'Poor quality',
                    'Below average',
                    'Issues with product',
                    'Not satisfied',
                    'Needs improvement'
                ],
                'comments' => [
                    'Disappointed with this purchase. The quality is not as advertised and it feels cheaply made.',
                    'Not what I expected. The product has several issues and doesn\'t match the description.',
                    'Poor quality materials and construction. I expected much better for this price point.',
                    'Below average product. There are quality issues that make it difficult to recommend.',
                    'Several problems with this item. The quality control seems lacking and it arrived damaged.',
                    'Not satisfied with this purchase. The product doesn\'t meet basic quality standards.',
                    'This product needs significant improvement. Multiple issues that affect usability.'
                ]
            ],
            // 1-star reviews
            [
                'rating' => 1,
                'titles' => [
                    'Terrible product',
                    'Complete waste of money',
                    'Awful quality',
                    'Do not buy',
                    'Worst purchase ever',
                    'Completely useless',
                    'Total disappointment'
                ],
                'comments' => [
                    'Terrible product! It broke within days of use and the quality is absolutely awful. Complete waste of money.',
                    'This is the worst purchase I have ever made. The product is completely useless and poorly made.',
                    'Awful quality and terrible customer service. I would not recommend this to anyone.',
                    'Do not buy this product! It\'s a complete scam and doesn\'t work at all as advertised.',
                    'Completely disappointed. The product is defective and the company refuses to help.',
                    'Total waste of money. The product is cheaply made and broke immediately.',
                    'One star is too generous. This product is completely useless and poorly designed.'
                ]
            ]
        ];

        foreach ($products as $product) {
            // Generate 2-8 reviews per product
            $numReviews = rand(2, 8);
            
            for ($i = 0; $i < $numReviews; $i++) {
                // Select random user (avoid duplicates for same product)
                $availableUsers = $users->reject(function($user) use ($product) {
                    return Review::where('product_id', $product->id)
                        ->where('user_id', $user->id)
                        ->exists();
                });
                
                if ($availableUsers->isEmpty()) {
                    break; // No more users available for this product
                }
                
                $user = $availableUsers->random();
                
                // Weight ratings towards higher scores (more realistic distribution)
                $ratingWeights = [5 => 40, 4 => 30, 3 => 20, 2 => 7, 1 => 3];
                $randomNum = rand(1, 100);
                $rating = 5; // default
                
                $cumulative = 0;
                foreach ($ratingWeights as $r => $weight) {
                    $cumulative += $weight;
                    if ($randomNum <= $cumulative) {
                        $rating = $r;
                        break;
                    }
                }
                
                // Get review template for this rating
                $template = collect($reviewTemplates)->firstWhere('rating', $rating);
                
                $title = $template['titles'][array_rand($template['titles'])];
                $comment = $template['comments'][array_rand($template['comments'])];
                
                // Determine approval status (90% approved, 10% pending)
                $isApproved = rand(1, 100) <= 90;
                
                Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => $rating,
                    'title' => $title,
                    'comment' => $comment,
                    'is_approved' => $isApproved,
                    'created_at' => now()->subDays(rand(1, 90)), // Random date within last 90 days
                ]);
                
                $reviewCount++;
            }
        }

        $this->command->info('✅ Reviews seeded successfully!');
        $this->command->info('📊 Products processed: ' . $products->count());
        $this->command->info('👥 Users available: ' . $users->count());
        $this->command->info('⭐ Total reviews created: ' . $reviewCount);
        
        // Show statistics
        $this->showStatistics();
    }

    /**
     * Show review statistics
     */
    private function showStatistics(): void
    {
        $stats = [
            'total_reviews' => Review::count(),
            'approved_reviews' => Review::where('is_approved', true)->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'average_rating' => Review::avg('rating'),
            'five_star_reviews' => Review::where('rating', 5)->count(),
            'four_star_reviews' => Review::where('rating', 4)->count(),
            'three_star_reviews' => Review::where('rating', 3)->count(),
            'two_star_reviews' => Review::where('rating', 2)->count(),
            'one_star_reviews' => Review::where('rating', 1)->count(),
        ];

        $this->command->info('');
        $this->command->info('📈 REVIEW STATISTICS:');
        $this->command->info('• Total Reviews: ' . number_format($stats['total_reviews']));
        $this->command->info('• Approved Reviews: ' . number_format($stats['approved_reviews']) . ' (' . round(($stats['approved_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• Pending Reviews: ' . number_format($stats['pending_reviews']) . ' (' . round(($stats['pending_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• Average Rating: ' . number_format($stats['average_rating'], 2) . '/5');
        $this->command->info('');
        $this->command->info('⭐ RATING DISTRIBUTION:');
        $this->command->info('• 5 Stars: ' . $stats['five_star_reviews'] . ' (' . round(($stats['five_star_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• 4 Stars: ' . $stats['four_star_reviews'] . ' (' . round(($stats['four_star_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• 3 Stars: ' . $stats['three_star_reviews'] . ' (' . round(($stats['three_star_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• 2 Stars: ' . $stats['two_star_reviews'] . ' (' . round(($stats['two_star_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
        $this->command->info('• 1 Star: ' . $stats['one_star_reviews'] . ' (' . round(($stats['one_star_reviews'] / $stats['total_reviews']) * 100, 1) . '%)');
    }
}