import java.util.*;

public class PermutariaDance {
    static final int MOD = 998244353;
    static final int MAX = 100005;
    static long[] fact = new long[MAX];
    static long[] invFact = new long[MAX];

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        int n = sc.nextInt();
        int x = sc.nextInt();
        sc.close();

        if (x > n) {
            // No way to place anyone
            System.out.println(fact(0)); // which is 1
            return;
        }

        precomputeFactorials(n);

        long[] dp = new long[n + 1];
        dp[0] = 1;

        for (int i = 1; i <= n; i++) {
            dp[i] = 0;
            for (int j = 0; j < i; j++) {
                if (Math.abs(i - j) >= x) {
                    dp[i] = (dp[i] + dp[j] * comb(i - 1, j) % MOD) % MOD;
                }
            }
        }

        System.out.println(dp[n]);
    }

    static void precomputeFactorials(int n) {
        fact[0] = 1;
        for (int i = 1; i <= n; i++) {
            fact[i] = fact[i - 1] * i % MOD;
        }

        invFact[n] = modInverse(fact[n]);
        for (int i = n - 1; i >= 0; i--) {
            invFact[i] = invFact[i + 1] * (i + 1) % MOD;
        }
    }

    static long comb(int n, int r) {
        if (r < 0 || r > n) return 0;
        return fact[n] * invFact[r] % MOD * invFact[n - r] % MOD;
    }

    static long modInverse(long a) {
        return pow(a, MOD - 2);
    }

    static long pow(long base, long exp) {
        long result = 1;
        while (exp > 0) {
            if ((exp & 1) == 1)
                result = result * base % MOD;
            base = base * base % MOD;
            exp >>= 1;
        }
        return result;
    }
}