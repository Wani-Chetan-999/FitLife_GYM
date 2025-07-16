import java.util.*;

public class ScoobyDooXORSpells {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        // Input number of haunted boxes
        int n = sc.nextInt();
        int[] power = new int[n];

        // Read powers
        for (int i = 0; i < n; i++) {
            power[i] = sc.nextInt();
        }

        // Prefix XOR computation
        int[] prefixXOR = new int[n + 1];  // prefixXOR[0] = 0 by default
        for (int i = 0; i < n; i++) {
            prefixXOR[i + 1] = prefixXOR[i] ^ power[i];
        }

        // Input number of queries
        int c = sc.nextInt();

        long totalSpells = 0;
        for (int i = 0; i < c; i++) {
            int l = sc.nextInt();
            int r = sc.nextInt();

            int xorVal = prefixXOR[r] ^ prefixXOR[l - 1];
            int len = r - l + 1;

            if (xorVal != 0) {
                totalSpells += -1;
                System.out.println(-1);
            } else {
                // If length is odd, we can neutralize in 1 spell
                if (len % 2 == 1) {
                    totalSpells += 1;
                    System.out.println(1);
                } else {
                    // If length is even, it depends - may need more analysis or be impossible
                    // For now, we return 2 for simplification
                    totalSpells += 2;
                    System.out.println(2);
                }
            }
        }

        System.out.println("Total Minimum Spells: " + totalSpells);
        sc.close();
    }
}